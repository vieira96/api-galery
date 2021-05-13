<?php

namespace App\Models\Album;

use App\Models\Photo\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $with = [
        'photos',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
