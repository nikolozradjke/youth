<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StaticDataAboutUs extends Model
{
    use HasTranslations;

    protected $translatable = [
        'about_us_title', 'about_us_subtitle', 'about_us_text'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'about_us_title', 'about_us_subtitle', 'about_us_text'
    ];
}
