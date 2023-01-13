<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanyStatus extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name'
    ];

    protected $fillable = [
        'name', 'can_be_filled'
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Company')->withPivot(['description']);
    }
}
