<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyCabinetMedia extends Model
{
    protected $fillable = [
        'media_url', 'study_id'
    ];

    public function studyCabinet()
    {
        return $this->belongsTo('App\StudyCabinet', 'study_id');
    }
}
