<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StaticDataCompanyRegistration extends Model
{
    use HasTranslations;

    protected $translatable = [
        'confidentiality_title', 'confidentiality_text', 'terms_title', 'terms_text'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confidentiality_title', 'confidentiality_text', 'terms_title', 'terms_text'
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
