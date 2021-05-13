<?php

namespace App\Services\Photo;

use App\Config\FilePath;
use App\Repositories\Photo\PhotoRepository;
use App\Helpers\File;
use App\Repositories\Album\AlbumRepository;
use Illuminate\Support\Facades\Auth;

class PhotoService
{
    use File;

    private $repository;
    private $album_repository;
    private $user;
    private $photo_dir;

    public function __construct(
        PhotoRepository $repository,
        AlbumRepository $album_repository
    ) {
        $this->repository = $repository;
        $this->album_repository = $album_repository;
        $this->user = Auth::user();
        $this->photo_dir = storage_path('photos').'/';
    }

    public function store($request)
    {
        $photos = [];
        $imageList = $request->file('photos');
        if (! $imageList) {
            throw new \Exception('exceptions.required_photos');
        }
        foreach ($imageList as $image) {
            $photo = $this->uploadPhoto($image);
            $photo['user_id'] = $this->user->id;
            $this->repository->store($photo);
            $photos[] = $photo;
        }
        //retorno as fotos criadas para serem exibidas no front.
        return $photos;
    }

    public function show($id)
    {
        $photo = $this->repository->findById($id);
        if (! $photo) {
            throw new \Exception('exceptions.not_found');
        }
        return $photo;
    }

    public function getUserPhotos()
    {
        return $this->repository->getUserPhotos($this->user->id);
    }

    public function delete($id)
    {
        $photo = $this->repository->findById($id);
        if (! $photo) {
            throw new \Exception('exceptions.not_found');
        }
        $this->deletePhoto($photo);
        $this->repository->delete($id);
    }

    public function maxDelete($request)
    {
        $photos = $this->repository->selectPhotos($request->array_of_id);
        foreach($photos as $photo) {
            $this->deletePhoto($photo);
        }

        $this->repository->deleteMany($request->array_of_id);
    }

    public function addToAlbum($request)
    {
        $data = $request->only([
            'album_id',
            'array_of_id',
        ]);
        $new_photos = [];
        $photos = $this->repository->selectPhotos($data['array_of_id']);
        foreach($photos as $photo) {
            $new_photo = $this->saveInAlbum($photo);
            $new_photo['user_id'] = $this->user->id;
            $new_photos[] = $new_photo;
        }
        $album = $this->album_repository->findById($data['album_id']);
        return $album->photos()->createMany($new_photos);

    }

}
