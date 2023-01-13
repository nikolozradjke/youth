<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityMedia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'media_url', 'opportunity_id'
      ];
  
      public function activities()
      {
        return $this->belongsTo('App\Activity', 'activity_id');
      }
}
