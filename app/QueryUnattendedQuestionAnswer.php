<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryUnattendedQuestionAnswer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'user_id', 'question_id', 'option_id', 'opportunity_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\QueryUnattendedQuestion', 'question_id');
    }

    public function option()
    {
        return $this->belongsTo('App\QueryUnattendedQuestionOption', 'option_id');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Opportunity');
    }
}
