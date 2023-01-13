<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QueryOpportunityProperty extends Model
{
    use HasTranslations;

    protected $translatable = [
        'text'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    public function queries()
    {
        return $this->belongsToMany('App\Query')->withPivot('order');
    }

    public function answers()
    {
        return $this->hasMany('App\QueryPropertyAnswer', 'property_id');
    }
}
