<?php

namespace App\Http\Resources\Photo;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            'url' => $this->url,
            'createad_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }

}
