<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasTranslations;

    static $DEFAULT_ROUTE = 'DEFAULT_ROUTE';

    protected $translatable = [
        'question', 'answer'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'answer', 'opportunity_id'
    ];

    public function opportunities()
    {
        return $this->belongsTo('App\Opportunity', 'opportunity_id');
    }
}
