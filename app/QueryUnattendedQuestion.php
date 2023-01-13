<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QueryUnattendedQuestion extends Model
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
        return $this->belongsToMany('App\Query', 'query_query_unattended_question', 'question_id', 'query_id')->withPivot('order');
    }

    public function options()
    {
        return $this->hasMany('App\QueryUnattendedQuestionOption', 'question_id');
    }

    public function answers()
    {
        return $this->hasMany('App\QueryUnattendedQuestionAnswer', 'question_id');
    }
}
