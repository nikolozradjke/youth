<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserDisability extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name'
    ];

    protected $fillable = [
        'name', 'disability_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot(['description']);
    }

    public function disability()
    {
        return $this->BelongsTo('App\Disability');
    }


    public function getImagePath()
    {
        $disability = $this->disability;

        if ($disability == null)
            return null;

        $path = $disability->logo_path;

        if (substr($path, 0, 9) === "/storage/") {
            $path = str_replace('/storage/', '', $path);
        }
        if (substr($path, 0, 8) === "storage/") {
            $path = str_replace('storage/', '', $path);
        }
        return $path;
    }
}
