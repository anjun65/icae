<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paper_code',
        'paper_title',
        'link_video',
        'presenter_name',
        'vita_presenter',
    ];
}
