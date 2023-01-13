<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

use function PHPSTORM_META\map;

class Company extends Authenticatable
{
    use HasTranslations;

    protected $translatable = [
        'name', 'address', 'description1', 'mission'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'registration_id',  'number_of_employees_id', 'address', 'password',
        'description1', 'fb_page', 'linkedin_page', 'web_page', 'document', 'image',
        'type', 'areal', 'cover_image', 'mission', 'registration_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'registration_date' => 'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    public function getShortURL()
    {
        $comURL = str_replace(' ', '-', $this->name);
        // url('/' . app()->getLocale() . '/organization/' . $company->id)
        $locale = app()->getLocale();
        if ($locale == 'ka')
            return BaseController::$SHORT_DOMAIN . "/o/" . $this->id;
        else
            return BaseController::$SHORT_DOMAIN . "/" . $locale . "/o/" . $this->id;
    }

    public function library()
    {
        return $this->hasMany('App\Library', 'company_id')->where('research', 0);
    }

    public function researches()
    {
        return $this->hasMany('App\Library', 'company_id')->where('research', 1);
    }

    public function place_of_registration()
    {
        return $this->hasOne('App\PlaceOfRegistration');
    }

    public function companyWorkingTypes()
    {
        return $this->belongsToMany('App\CompanyWorkingType')->withPivot('description');
    }

    // Municipalites where company works (not registered!)
    public function workingMunicipalities()
    {
        return $this->belongsToMany('App\Municipality', 'company_working_municipalities');
    }

    // Regions where company works (not registered!)
    public function workingRegions()
    {
        return $this->belongsToMany('App\Region', 'company_working_region');
    }

    public function company_statuses()
    {
        return $this->belongsToMany('App\CompanyStatus')->withPivot(['description']);
    }

    public function number_of_employees()
    {
        return $this->belongsTo('App\NumberOfEmployees');
    }

    public function opportunities()
    {
        return $this->hasMany('App\Opportunity')->where('inactive', false);
    }

    public function regions()
    {
        return $this->belongsToMany('App\Region');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category')->withPivot(['description']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function subscribedCategories()
    {
        return $this->belongsToMany('App\Category', 'company_subscribed_category', 'company_id', 'category_id');
    }

    // companies that are subscribed by this company
    public function subscribedCompanies()
    {
        return $this->belongsToMany('App\Company', 'company_company', 'subscriber_id', 'subscribed_id');
    }

    // companies that are subscribers of this company
    public function subscriberCompanies()
    {
        return $this->belongsToMany('App\Company', 'company_company', 'subscribed_id', 'subscriber_id');
    }

    public function queryMessages()
    {
        return $this->hasMany('App\QueryMessage');
    }

    public function privateMessages()
    {
        return $this->queryMessages()->where('is_private', true)->orderBy('created_at', 'desc')->get();
    }


    public function subscribeToCompany($companyId)
    {
        $this->subscribedCompanies()->attach($companyId);
    }

    public function unsubscribeToCompany($companyId)
    {
        $this->subscribedCompanies()->detach($companyId);
    }

    public function subscribeToCategory($categoryId)
    {
        $this->subscribedCategories()->attach($categoryId);
    }

    public function unsubscribeToCategory($categoryId)
    {
        $this->subscribedCategories()->detach($categoryId);
    }

    public function isSubscribedToCompany($companyId)
    {
        return $this->subscribedCompanies()->find($companyId);
    }

    public function isSubscribedToCategory($categoryId)
    {
        return $this->subscribedCategories()->find($categoryId);
    }

    public function getImagePath()
    {
        $path = $this->image;
        if (substr($path, 0, 9) === "/storage/") {
            $path = str_replace('/storage/', '', $path);
        }
        if (substr($path, 0, 8) === "storage/") {
            $path = str_replace('storage/', '', $path);
        }
        return $path;
    }

    public function favoriteOpportunities()
    {
        return $this->belongsToMany('App\Opportunity', 'company_favorite_opportunity');
    }

    public function addFavoriteOpportunity($id)
    {
        if (!$this->favoriteOpportunities()->find($id)) {
            $this->favoriteOpportunities()->attach($id);
            return true;
        }
        return false;
    }

    public function removeFavoriteOpportunity($id)
    {
        $this->favoriteOpportunities->detach($id);
        return true;
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function get_next_feedbacks($curLoaded = 0, $numberPerPage = 4)
    {
        $opportunities = $this->opportunities;
        $feedbacks = [];
        foreach ($opportunities as $opp) {
            $oppfeedbacks = $opp->queryMessages()->with(['user', 'opportunity'])->get();
            foreach ($oppfeedbacks as $oppfeedback) {
                array_push($feedbacks, $oppfeedback);
            }
        }

        $hasMore = sizeof($feedbacks) >= $curLoaded + $numberPerPage;
        $feedbacks = array_slice($feedbacks, $curLoaded, $numberPerPage);
        return array(collect($feedbacks), $hasMore);
    }

    public function getCoverPath()
    {
        $path = $this->cover_image;
        if (substr($path, 0, 9) === "/storage/") {
            $path = str_replace('/storage/', '', $path);
        }
        if (substr($path, 0, 8) === "storage/") {
            $path = str_replace('storage/', '', $path);
        }
        return $path;
    }

    public function ongoingOpportunities()
    {
        return $this->opportunities()->whereRaw('schedule_date <= NOW()')->whereRaw('end_date >= NOW()');
    }

    public function finishedOpportunities()
    {
        return $this->opportunities()->whereRaw('schedule_date <= NOW()')->whereRaw('end_date < NOW()');
    }

    public function companyOpportunitiesAnswers()
    {
        return $this->hasManyThrough('App\QueryQuestionAnswer', 'App\Opportunity',  'company_id',  'opportunity_id',  'id', 'id');
    }

    public function companyOpportunitiesPropertiesAnswers()
    {
        return $this->hasManyThrough('App\QueryPropertyAnswer', 'App\Opportunity',  'company_id',  'opportunity_id',  'id', 'id');
    }

    public function companyOpportunitiesPropertiesAnswersYes()
    {
        return $this->companyOpportunitiesPropertiesAnswers()->where('answer', '1');
    }

    public function companyGetAnswersByQuestionId($questionId)
    {
        return $this->companyOpportunitiesAnswers()->where('question_id', $questionId);
    }

    public function companyGetAnswersAvgByQuestionId($questionId)
    {
        return $this->companyGetAnswersByQuestionId($questionId)->avg('answer');
    }

    public function companyAvgScore()
    {
        return $this->companyOpportunitiesAnswers()->avg('answer');
    }

    public function subscriberCount()
    {
        $companyUsers = $this->users;
        $companyCompanies = $this->subscriberCompanies;

        return $companyUsers->count() + $companyCompanies->count();
    }
}
