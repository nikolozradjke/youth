<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserSector extends Model
{
    use HasTranslations;
    protected $translatable = [
        'name'
    ];
    protected $fillable = ['name'];
}
