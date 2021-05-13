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

        $mime = '.'.$file->extension();
        $name = time().rand(0,9999).$mime;
        $img->save(PHOTO_DIR.$name);
        //retorno a url da imagem criada para salvar no banco
        $photo['photo_name'] = $name;
        $photo['url'] = config('app.url').'/photos/'.$name;
        return $photo;
    }

    public function deletePhoto($photo)
    {
        $image = PHOTO_DIR.$photo->photo_name;
        if ( file_exists($image)) {
            unlink($image);
        }
    }
}
