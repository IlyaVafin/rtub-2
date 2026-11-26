<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'name' => $this->name,
            "description" => $this->when($this->withDescription ?? false, function() {
                return $this->description;
            }),
            "preview" => Storage::disk('public')->url($this->preview),
            "video" => $this->when($this->withVideo ?? false, function() {
                return Storage::disk('public')->url($this->video);
            }),
            "author" => $this->user()->first()->nickname,
            "views" => $this->views,
            "status" => $this->when($this->withStatus ?? false, function() {
                return $this->status;
            }),
            "created_at" => $this->created_at->format('Y-m-d'),
            "updated_at" => $this->updated_at->format('Y-m-d'),
        ];
    }
}
