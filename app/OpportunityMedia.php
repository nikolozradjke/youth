<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpportunityMedia extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'media_url', 'opportunity_id'
    ];

    public function opportunities()
    {
      return $this->belongsTo('App\Opportunity', 'opportunity_id');
    }
}
