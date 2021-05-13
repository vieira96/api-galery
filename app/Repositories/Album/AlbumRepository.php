<?php

namespace App\Repositories\Album;

use App\Models\Album\Album;
use App\Repositories\BaseRepository;

class AlbumRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Album());
    }

    public function getUserAlbums($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }
}
