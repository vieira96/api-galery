<?php

namespace App\Http\Controllers\Api\Album;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\AlbumRequest;
use App\Http\Requests\Photo\PhotoRequest;
use App\Http\Resources\Album\AlbumResource;
use App\Services\Album\AlbumService;

class AlbumController extends Controller
{
    private $service;

    public function __construct(AlbumService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = AlbumResource::collection(
                $this->service->getUserAlbums()
            );
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage());
        }
        return $this->responseSuccess($data);
    }

    public function show($id)
    {
        try {
            $data = new AlbumResource(
                $this->service->show($id)
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function store(AlbumRequest $request)
    {
        try {
            $data = new AlbumResource(
                $this->service->store($request)
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function update(AlbumRequest $request, $id)
    {
        try {
            $data = new AlbumResource(
                $this->service->update($request, $id)
            );
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess();
    }

    public function addPhoto(PhotoRequest $request, $album_id)
    {
        try {
            $data = $this->service->addPhoto($request, $album_id);
        } catch( \Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }
}
