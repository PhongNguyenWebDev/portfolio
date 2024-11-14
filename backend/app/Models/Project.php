<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image_project', 'description', 'image_tech', 'url'];
    protected $casts = [
        'image_tech' => 'json',  // Chuyển đổi trường này thành mảng khi truy xuất
    ];
}
