<?php

namespace App\Http\Resources\Album;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photos' => $this->formatPhotos($this->photos),
        ];
    }

    public function formatPhotos($photos)
    {
        return $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => $photo->url,
            ];
        });
    }
}
