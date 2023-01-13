<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberOfEmployees extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'min', 'max'
    ];

    public function companies()
    {
        return $this->hasMany('App\Company');
    }
}
