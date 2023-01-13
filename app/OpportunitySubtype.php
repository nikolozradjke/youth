<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\OpportunityFilter;

class OpportunitySubtype extends Model
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
        'name',
    ];

    public function opportunity_type()
    {
        return $this->belongsTo('App\OpportunityType');
    }

    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity');
    }

    public function subtype_opportunities()
    {
        $opportunities = OpportunityFilter::filterOpportunities(['subtypes' => [$this->id]]);
        return $opportunities;
    }
}
