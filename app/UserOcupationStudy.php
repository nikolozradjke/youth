<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserOcupationStudy extends Model
{
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
