<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'slug' => $this->slug,
            'image' => $this->image,
            'github_url' => $this->github_url,
            'live_url' => $this->live_url,
            'sort_order'=>$this->sort_order,
            'is_featured' => $this->is_featured,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'technologies' => TechnologyResource::collection($this->whenLoaded('technologies')),
        ];
    }
}
