<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingOpportunityAttribute extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity_id', 'field', 'value'
    ];

    public function opportunity()
    {
        return $this->belongsTo('App\Opportunity');
    }
}
