<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Disability extends Model
{
    use HasTranslations;

    protected $translatable = [
        'type', 'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'description', 'logo_path'
    ];


    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity');
    }

    public function userDisabilities()
    {
        return $this->hasMany('App\UserDisability');
    }

    public function getImagePath()
    {
        $path = $this->logo_path;
        if (substr($path, 0, 9) === "/storage/") {
            $path = str_replace('/storage/', '', $path);
        }
        if (substr($path, 0, 8) === "storage/") {
            $path = str_replace('storage/', '', $path);
        }
        return $path;
    }
}
