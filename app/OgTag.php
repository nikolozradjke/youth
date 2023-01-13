<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OgTag extends Model
{
    use HasTranslations;

    static $DEFAULT_ROUTE = 'DEFAULT_ROUTE';

    protected $translatable = [
        'title', 'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image', 'route_name'
    ];
}
