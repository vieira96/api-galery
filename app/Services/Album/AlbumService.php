<?php

namespace App\Services\Album;

use App\Config\FilePath;
use App\Repositories\Album\AlbumRepository;
use App\Helpers\File;
use App\Repositories\Photo\PhotoRepository;
use Illuminate\Support\Facades\Auth;

class AlbumService
{
    use File;

    private $repository;
    private $photo_repository;
    private $user;

    public function __construct(AlbumRepository $repository, PhotoRepository $photo_repository)
    {
        $this->repository = $repository;
        $this->photo_repository = $photo_repository;
        $this->user = Auth::user();
    }

    public function store($request)
    {
        $data = $request->only(['name']);
        $data['user_id'] = $this->user->id;
        $album = $this->repository->store($data);
        $imageList = $request->file('photos');
        if ($imageList) {
            $photos = [];
            foreach ($imageList as $image) {
                $photo = $this->uploadPhoto($image);
                $photo['user_id'] = $this->user->id;
                array_push($photos, $photo);
            }
            //cria todas as fotos adicionadas ao album
            $album->photos()->createMany($photos);
        }

        //retorno as fotos criadas para serem exibidas no front.
        return $album;
    }

    public function show($id)
    {
        $photo = $this->repository->findById($id);
        if (! $photo) {
            throw new \Exception('exceptions.not_found');
        }
        return $photo;
    }

    public function getUserAlbums()
    {
        return $this->repository->getUserAlbums($this->user->id);
    }

    public function update($request, $id)
    {
        $data = $request->only([
            'name'
        ]);
        return $this->repository->update($data, $id);
    }

    public function delete($id)
    {
        $album = $this->repository->findById($id);
        if (! $album) {
            throw new \Exception('exceptions.not_found');
        }
        if (count($album->photos)) {
            foreach($album->photos as $photo) {
                $this->deletePhoto($photo);
            }
        }

        $this->repository->delete($id);
    }

    public function addPhoto($request, $album_id)
    {
        $imageList = $request->file('photos');
        if (! $imageList) {
            throw new \Exception('exceptions.required_photos');
        }
        $album = $this->repository->findById(($album_id));
        if (! $album) {
            throw new \Exception('exceptions.not_found');
        }
        $photos = [];
        foreach($imageList as $image) {
            $photo = $this->uploadPhoto($image);
            $photo['user_id'] = $this->user->id;
            $photos[] = $photo;
        }
        return $album->photos()->createMany($photos);
    }
}
