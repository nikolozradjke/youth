<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceOfRegistration extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_georgia', 'address_text', 'company_id', 'region_id', 'municipality_id'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Municipality');
    }
}
