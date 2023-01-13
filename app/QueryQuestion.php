<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QueryQuestion extends Model
{
    use HasTranslations;

    protected $translatable = [
        'text', 'details'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'details'
    ];

    public function queries()
    {
        return $this->belongsToMany('App\Query')->withPivot('order');
    }

    public function answers()
    {
        return $this->hasMany('App\QueryQuestionAnswer', 'question_id');
    }
}
