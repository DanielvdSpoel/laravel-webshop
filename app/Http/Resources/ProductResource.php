<?php

namespace App\Http\Resources;

use FilamentCurator\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = [];
        foreach ($this->images as $image) {
            $media = Media::find($image['image']);
            $images[] = [
                'id' => $media->id,
                'alt' => $media->alt,
                'url' => $media->url,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => $images,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'urls' => [
                'show' => 'Something',
                'cart' => 'Something',
            ],
        ];
    }
}
