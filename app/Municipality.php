<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Municipality extends Model
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
        'name', 'region_id'
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    // Municipalities where company works (not registered!)
    public function workingCompany()
    {
        return $this->belongsToMany('App\Company', 'company_working_municipalities');
    }

    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity');
    }
}
