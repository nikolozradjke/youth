<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StaticDataMainPage extends Model
{
    use HasTranslations;

    public $translatable = ['user_section_title', 'user_section_subtitle', 'user_section_text'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_section_title', 'user_section_subtitle', 'user_section_text', 'order', 'for_company'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
}
