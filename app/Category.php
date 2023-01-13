<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'has_description'
    ];

    public function companies()
    {
        return $this->belongsToMany('App\Company')->withPivot(['description']);
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity');
    }

    public function getOpportunityCount()
    {
        return $this->opportunities()->whereRaw('schedule_date <= NOW()')->join('companies', function ($join) {
            $join->on('opportunities.company_id', '=', 'companies.id');
        })->where('companies.approved', 1)->distinct('opportunities.id')->count();
    }

}
