<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LibraryCategory extends Model
{
    use HasTranslations;

    protected $fillable = ['name', 'category_id'];

    protected $translatable = [
        'name'
    ];

    public function parent()
    {
        return $this->belongsTo('App\LibraryCategory', 'category_id');
    }

    public function children()
    {
        return $this->hasMany('App\LibraryCategory', 'category_id');
    }
}
