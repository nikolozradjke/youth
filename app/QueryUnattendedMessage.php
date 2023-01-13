<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryUnattendedMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'user_id', 'opportunity_id', 'is_private'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Opportunity');
    }
}
