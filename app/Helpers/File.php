<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

define ('PHOTO_DIR' , storage_path('photos').'/');

trait File {

    public function uploadPhoto($file)
    {
        if(! is_dir(PHOTO_DIR)) {
            mkdir(PHOTO_DIR, 0777, true);
        }
        $img = Image::make($file);
        $mime = explode('/', $img->mime);
        $name = time().rand(0,9999).'.'.$mime[1];
        $img->save(PHOTO_DIR.$name);
        //retorno a url da imagem criada para salvar no banco
        $photo['photo_name'] = $name;
        //pega a url base direto do .env
        $photo['url'] = config('app.url').'/photos/'.$name;
        return $photo;
    }

    public function deletePhoto($photo)
    {
        $image = PHOTO_DIR.$photo->photo_name;
        if (file_exists($image)) {
            unlink($image);
        }
    }

    public function saveInAlbum($photo)
    {
        $photo = PHOTO_DIR.$photo->photo_name;
        if (file_exists($photo)) {
            return $this->uploadPhoto($photo);
        }
    }
}
