<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Giải mã JSON của image_tech nếu có
        $imageTechPaths = $this->image_tech
            ? json_decode($this->image_tech, true)  // Giải mã chuỗi JSON thành mảng
            : [];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image_project' => $this->image_project ? Storage::url($this->image_project) : null,
            'image_tech' => !empty($imageTechPaths)
                ? array_map(fn($path) => Storage::url($path), $imageTechPaths)  // Chuyển đổi mảng các đường dẫn thành URL
                : null,
        ];
    }
}
