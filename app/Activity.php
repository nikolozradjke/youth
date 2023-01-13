<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Activity extends Model implements HasMedia
{

    use HasTranslations;
    use HasMediaTrait;

    protected $fillable = [
        'name', 'count', 'duration', 'level', 'steps', 'user_id', 'company', 'status'
    ];

    protected $translatable = [
        'name', 'count', 'duration', 'level', 'steps'
    ];

    public function activity_medias()
    {
        return $this->hasMany("App\ActivityMedia");
    }

    public function getImagePath()
    {
        $path = $this->image;
        if (substr($path, 0, 9) === "/storage/") {
            $path = str_replace('/storage/', '', $path);
        }
        if (substr($path, 0, 8) === "storage/") {
            $path = str_replace('storage/', '', $path);
        }
        return $path;
    }

    public function registerMediaConversions(Media $media = null)
    {
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('file');
    }
}
