<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanyWorkingType extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name', 'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'can_be_filled'
    ];

    public function CompanyWorkingSubtype()
    {
        return $this->hasMany('App\CompanyWorkingSubtype');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }
}
