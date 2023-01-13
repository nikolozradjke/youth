<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slide extends Model
{
    use HasTranslations;

    protected $translatable = [
        'title', 'text'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'content_path', 'presentation_id'
    ];

    public function presentation()
    {
        return $this->belongsTo('App\Presentation');
    }
}
