<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryQuestionAnswer extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'opportunity_id', 'question_id', 'answer'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Opportunity', 'opportunity_id');
    }

    public function question()
    {
        return $this->belongsTo('App\QueryQuestion', 'question_id');
    }
}
