<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SliderResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'position' => $this->position,
            'url_cv' => $this->url_cv ? basename($this->url_cv) : null, // Lấy chỉ tên file mà không có đường dẫn
            'image' => $this->image ? Storage::url($this->image) : null, // Nếu bạn vẫn muốn đường dẫn đầy đủ cho hình ảnh
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
