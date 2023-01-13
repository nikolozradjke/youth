<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Role extends Model
{
    use HasTranslations;

    protected $translatable = [
        'role'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }
}
