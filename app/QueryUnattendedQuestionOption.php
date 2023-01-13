<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QueryUnattendedQuestionOption extends Model
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
        'text', 'has_text_field', 'question_id'
    ];

    public function question()
    {
        return $this->belongsTo('App\QueryUnattendedQuestion', 'question_id');
    }

    public function answers()
    {
        return $this->hasMany('App\QueryUnattendedQuestionAnswer', 'option_id');
    }
}
