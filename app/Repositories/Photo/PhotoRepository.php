<?php

namespace App\Repositories\Photo;

use App\Models\Photo\Photo;
use App\Repositories\BaseRepository;

class PhotoRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Photo());
    }

    //metodo para pegar as fotos que foram marcadas para deletar pelo usuario
    public function selectPhotos($array_of_id)
    {
        return $this->model->whereIn('id', $array_of_id)->get();
    }

    public function deleteMany($array_of_id)
    {
        return $this->model->destroy($array_of_id);
    }

    public function getUserPhotos($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }
}
