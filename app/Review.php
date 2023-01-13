<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'dificulty', 'age', 'improvement', 'pages', 'review'
    ];
}
