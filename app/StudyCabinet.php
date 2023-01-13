<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Translatable\HasTranslations;

class StudyCabinet extends Model implements HasMedia
{
    use HasTranslations;
    use HasMediaTrait;

    protected $fillable = [
        'name', 'description','duration','team_size','activity_size','activity_level','image','file','user_id','company_id'
    ];
    
    protected $translatable = [
        'name', 'description'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function company(){
        return $this->belongsTo('App\Company', 'company_id');
    }
    
    public function medias()
    {
        return $this->hasMany("App\StudyCabinetMedia", 'study_id');
    }
}
