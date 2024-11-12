<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkEx extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'work_experience';
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'gpa',
        'gpa_scale',
        'position',
    ];
}
