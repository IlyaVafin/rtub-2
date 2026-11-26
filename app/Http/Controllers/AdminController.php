<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        $user = auth()->user();
        if($user) return redirect('/rtub_admin/videos');
        return view('login');
    }
    public function videos(Request $request) {
        $search = $request->query('query');
        $videos = Video::where('status', 'moderation')->when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(10);
        return view('videos', compact('videos'));
    }
    public function auth(Request $request) {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required|string|min:3"
        ]);
        if(Auth::attempt($data)) {
            $user = auth()->user();
            if(!$user->superuser) {
                return back()->withErrors(["error" => "You are not admin"]);
            }
            $request->session()->regenerate();
            return redirect('/rtub_admin/videos');
        } else {
            return back()->withErrors(['error' => "Invalid email or password"]);
        }
    }

    public function approve(Request $request, Video $video) {
        $video->update(['status' => 'approved']);
        return redirect('/rtub_admin/videos');
    }

    public function reject(Request $request, Video $video) {
        $video->update(['status' => 'rejected']);
        return redirect('/rtub_admin/videos');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/rtub_admin');
    }
}
