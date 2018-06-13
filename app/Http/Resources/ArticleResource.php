<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes = parent::toArray($request);
        $attributes['body_image'] = url($attributes['body_image']);
        $attributes['thumbnail_image'] = url($attributes['thumbnail_image']);
        return $attributes;
    }
}
