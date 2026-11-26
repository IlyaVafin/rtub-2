<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('query');
        $videos = Video::query()->where('status', 'approved')->orWhere(fn($query) => $query->orWhere('title', 'like', '%' . $search . '%'));
        if($request->filled('min_views')) {
            $videos->where('views', '>=', $request->min_views);
        }
        if($request->filled('max_views')) {
            $videos->where('views', '<=', $request->max_views);
        }

        $videos = $videos->orderBy('views', $request->sort == 'asc' ? 'asc' : 'desc')->paginate(10);
        return response()->json([
            "data" => VideoResource::collection($videos->items()),
            "per_page" => $videos->perPage(),
            "current_page" => $videos->currentPage(),
            "last_page" => $videos->lastPage(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            "name" => "required|string|min:3|max:255",
            "description" => "sometimes|string|min:10",
            "preview" => "sometimes|image|mimes:png,jpg|max:2560",
            "video" => "required|mimes:mp4|max:4096",
        ]);
        $videoPath = $request->file("video")->store("video");
        $previewPath = null;
        if($request->hasFile("preview")) {
            $previewPath = $request->file("preview")->store("preview");
        }
        $video = Video::create([
            "name" => $data["name"],
            "description" => $data["description"] ?? "",
            "user_id" => $user->id,
            "preview" => $previewPath,
            "video" => $videoPath,
        ]);
        $video->withDescription = true;
        $video->withVideo = true;
        return response()->json([
            "data" => new VideoResource($video)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video->update(['views' => $video->views + 1]);
        return response()->json([
            "data" => [
                "video" => new VideoResource($video)->additional(["withDescription" => true]),
            ]
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $user = auth()->user();
        if($user->id != $video->user_id) abort(403);
        $data = $request->validate([
            "name" => "sometimes|string|min:3|max:255",
            "description" => "sometimes|string|min:10",
            "preview" => "sometimes|image|mimes:png,jpg|max:2560",
            "video" => "sometimes|mimetype:video/mp4|max:4096",
        ]);
        if($request->hasFile('video')) {
            Storage::disk('public')->delete(Str::after($video->video, '/storage'));
            $videoPath = $request->file('video')->store('videos');
            $data['video'] = $videoPath;
        }
        if($request->hasFile("preview")) {
            Storage::disk('public')->delete(Str::after($video->preview, '/storage'));
            $previewPath = $request->file("preview")->store("preview");
            $data['preview'] = $previewPath;
        }
        $video->update([...$data, 'status' => "moderation"]);
        $video->withStatus = true;
        $video->withVideo = true;
        return response()->json([
            "data" => new VideoResource($video)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $user = auth()->user();
        if($user->id != $video->user_id) return abort(403);
        $video->delete();
        return response()->noContent();
    }
}
