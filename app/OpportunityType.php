<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\OpportunityFilter;

class OpportunityType extends Model
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

    public function subtypes()
    {
        return $this->hasMany('App\OpportunitySubtype');
    }

    public function get_opportunities()
    {
        $subtypes = $this->subtypes->pluck('id')->toArray();
        $opportunities = OpportunityFilter::filterOpportunities(['subtypes' => $subtypes]);
        return $opportunities;
    }

    public function getOpportunityCount()
    {
        return sizeof($this->get_opportunities());
    }
}
