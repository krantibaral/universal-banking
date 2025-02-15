<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    public function registerMediaConversions(Media|null $media = null): void
    {
        try {
            $this->addMediaConversion('thumb')
                ->width(160)
                ->height(160);

            $this->addMediaConversion('medium')
                ->width(320)
                ->height(320);
        } catch (InvalidManipulation $e) {
            // Handle the exception
        }
    }

    function getImage($collectionName = null)
    {
        if ($collectionName) {
            if ($this->getMedia($collectionName)->isEmpty())
                return null;
            return $this->getFirstMediaUrl($collectionName);
        } else {
            if ($this->getMedia()->isEmpty())
                return null;
            return $this->getFirstMediaUrl();
        }
    }

    function getImageByIndex($index = 0)
    {
        if ($this->getMedia()->isEmpty())
            return null;
        try {
            return $this->getMedia()[$index]->getUrl();
        } catch (\Exception $e) {
            return null;
        }
    }

    function getThumbnail($collectionName = null)
    {
        if ($collectionName) {
            if ($this->getMedia($collectionName)->isEmpty())
                return null;
            return $this->getMedia($collectionName)->first()->getUrl('thumb');
        } else {
            if ($this->getMedia()->isEmpty())
                return null;
            return $this->getMedia()->first()->getUrl('thumb');
        }
    }
}
