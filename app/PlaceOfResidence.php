<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceOfResidence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_georgia', 'address_text', 'user_id', 'region_id', 'municipality_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
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
