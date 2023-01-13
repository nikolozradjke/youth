<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }

    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity');
    }

    public function municipalities()
    {
        return $this->hasMany('App\Municipality');
    }

    // Regions where company works (not registered!)
    public function workingCompanies()
    {
        return $this->belongsToMany('App\Company', 'company_working_region');
    }
}
