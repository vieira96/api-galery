<?php

namespace App\Models\Photo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'album_id'
    ];

    protected $fillable = [
        'url',
        'photo_name',
        'user_id',
        'album_id'
    ];
}
