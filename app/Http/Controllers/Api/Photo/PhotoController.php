<?php

namespace App\Http\Controllers\Api\Photo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Photo\PhotoRequest;
use App\Http\Resources\Photo\PhotoResource;
use App\Services\Photo\PhotoService;

class PhotoController extends Controller
{
    private $service;

    public function __construct(PhotoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = PhotoResource::collection(
                $this->service->getUserPhotos()
            );
        } catch( \Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function show($id)
    {
        try {
            $data = $this->service->show($id);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function store(PhotoRequest $request)
    {
        try {
            $data = $this->service->store($request);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($data);
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
        } catch ( \Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess();
    }

    public function maxDelete(PhotoRequest $request)
    {
        try {
            $this->service->maxDelete($request);
        } catch( \Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess();
    }
}
