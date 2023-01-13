<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OpportunityStatus extends Model
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

    public function opportunities()
    {
        return $this->hasMany('App\Opportunity');
    }
}
