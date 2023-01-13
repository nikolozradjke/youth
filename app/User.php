<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use Notifiable;
    use HasTranslations;

    protected $translatable = [
        'first_name', 'last_name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'company', 'birth_date', 'private_number', 'gender', 'image',
        'email', 'phone', 'password', 'is_complete', 'provider_id', 'provider',
        'user_occupation_id', 'user_ocupation_work_id', 'user_ocupation_study_id', 'ocupation_description',
        'currently_studying','edu_name','edu_grade','edu_info','study_status','sector_id','sphere_id','other_sector'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        'birth_date' => 'date'
    ];

    public static function auth()
    {
        $user = null;

        $guard = null;

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }

        return [
            'user' => $user,
            'guard' => $guard
        ];
    }
    
    public function opportunities()
    {
        return $this->hasMany('App\Opportunity')->where('inactive', false);
    }
    
    public function users()
    {
        return $this->belongsToMany('App\User', 'company_user', 'company_id', 'user_id');
    }
    
    public function subscriberCompanies()
    {
        return $this->belongsToMany('App\Company', 'company_company', 'subscribed_id', 'subscriber_id');
    }

    public function userSphere()
    {
        return $this->belongsTo('App\UserSphere');
    }

    public function userSector()
    {
        return $this->belongsTo('App\UserSector');
    }

    public function library()
    {
        return $this->hasMany('App\Library', 'user_id')->where('research', 0);
    }

    public function researches()
    {
        return $this->hasMany('App\Library', 'user_id')->where('research', 1);
    }

    public function userEducations()
    {
        return $this->belongsToMany('App\UserEducation')->withPivot('study_description');
    }

    public function userOccupation()
    {
        return $this->belongsTo('App\UserOccupation');
    }

    public function userDisabilities()
    {
        return $this->belongsToMany('App\UserDisability')->withPivot(['description']);
    }

    public function place_of_residence()
    {
        return $this->hasOne('App\PlaceOfResidence');
    }

    public function userOcupationWork()
    {
        return $this->belongsTo('App\UserOcupationWork');
    }

    public function userOcupationStudy()
    {
        return $this->belongsTo('App\UserOcupationStudy');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function subscribedCategories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company');
    }

    public function subscribedCompanies()
    {
        return $this->companies();
    }

    public function subscribeToCompany($companyId)
    {
        $this->companies()->attach($companyId);
    }

    public function unsubscribeToCompany($companyId)
    {
        $this->companies()->detach($companyId);
    }

    public function subscribeToCategory($categoryId)
    {
        $this->categories()->attach($categoryId);
    }

    public function unsubscribeToCategory($categoryId)
    {
        $this->categories()->detach($categoryId);
    }

    public function isSubscribedToCompany($companyId)
    {
        return $this->companies()->find($companyId);
    }

    public function isSubscribedToCategory($categoryId)
    {
        return $this->categories()->find($categoryId);
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

    public function goingOpportunities()
    {
        return $this->belongsToMany('App\Opportunity')->withPivot(['attended', 'approved', 'random_id']);
    }

    public function favoriteOpportunities()
    {
        return $this->belongsToMany('App\Opportunity', 'user_favorite_opportunity');
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
        $this->favoriteOpportunities()->detach($id);
        return true;
    }

    public function isFavorite($id)
    {
        if ($this->favoriteOpportunities()->find($id)) {
            return true;
        }
        return false;
    }

    private function generateRandomString($length = 60)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public function addGoingOpportunity($id)
    {
        if (!$this->goingOpportunities()->find($id)) {
            $rid = $this->generateRandomString(60);
            $this->goingOpportunities()->attach($id, ['random_id' => $rid]);
            return true;
        }
        return false;
    }

    public function getRandomId($opportunityId)
    {
        $opportunity = $this->goingOpportunities()->where('opportunity_id', $opportunityId)->first();
        if ($opportunity == null)
            return null;
        return $opportunity->pivot->random_id;
    }

    public function removeRandomId($opportunityId)
    {
        $opportunity = $this->goingOpportunities()->where('opportunity_id', $opportunityId)->first();
        if ($opportunity == null)
            return false;

        $this->goingOpportunities()->updateExistingPivot($opportunityId, ['random_id' => '']);
        return true;
    }

    public function removeGoingOpportunity($id)
    {
        $this->goingOpportunities()->detach($id);
        return true;
    }

    public function isGoing($id)
    {
        if ($this->goingOpportunities()->find($id)) {
            return true;
        }
        return false;
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function interactedQueryMessages()
    {
        return $this->belongsToMany('App\QueryMessage')->withPivot('delta');
    }

    public function likedQueryMessages()
    {
        return $this->interactedQueryMessages()->wherePivot('delta', 1)->get();
    }

    public function dislikedUQueryMessages()
    {
        return $this->interactedQueryMessages()->wherePivot('delta', 0)->get();
    }

    public function isLikedQueryMessage($id)
    {
        if ($this->interactedQueryMessages()->wherePivot('delta', 1)->where('query_message_id', $id)->first()) {
            return true;
        }
        return false;
    }

    // isLike defines whether the message is liked, disliked or undone
    public function likeQueryMessage($id, $isLike)
    {
        $this->interactedQueryMessages()->detach($id);
        if ($isLike >= 0) {
            $this->interactedQueryMessages()->attach($id, ['delta' => $isLike]);
        }
    }

    public function opportunityMessage($opportunity_id){
        return $this->hasMany('App\QueryMessage')->whereNull('company_id')->first();
    }

    public function opportunityCompanyMessage($opportunity_id){
        return $this->hasMany('App\QueryMessage')->whereNotNull('company_id')->first();
    }
}
