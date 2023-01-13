<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Presentation extends Model
{
    use HasTranslations;

    protected $translatable = [
        'title'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    public function slides()
    {
        return $this->hasMany('App\Slide', 'presentation_id');
    }
}
