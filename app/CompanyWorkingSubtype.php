<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanyWorkingSubtype extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company_working_type_id'
    ];

    public function CompanyWorkingType()
    {
        return $this->belongsTo('App\CompanyWorkingType');
    }
}
