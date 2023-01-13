<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Library extends Model implements HasMedia
{
    use HasTranslations;
    use HasMediaTrait;

    protected $fillable = [
        'name', 'category_id', 'youtube', 'file', 'status', 'research', 'user_id', 'company_id'
    ];

    protected $translatable = [
        'name'
    ];

    public function category(){
        return $this->belongsTo('App\LibraryCategory', 'category_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function company(){
        return $this->belongsTo('App\Company', 'company_id');
    }


}
