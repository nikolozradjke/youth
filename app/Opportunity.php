<?php

namespace App;

use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Month;

class Opportunity extends Model implements HasMedia
{
    use HasTranslations;
    use HasMediaTrait;

    protected $translatable = [
        'name', 'description', 'address'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'address', 'start_date', 'end_date', 'schedule_date',
        'company_id', 'user_id', 'image', 'order', 'phone', 'web_page', 'fb_page', 'linkedin_page', 'latitude', 'longitude', 'application_url', 'query_id',
        'min_age', 'max_age', 'is_virtual', 'vitual_link', 'live_translation_link', 'is_draft', 'draft_token', 'inactive'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        'start_date'    => 'date',
        'end_date'      => 'date',
        'schedule_date' => 'date'
    ];

    public static function createNewInactive()
    {
        $opportunity = new Opportunity();
        
        $user = User::auth();
        if($user['guard'] == 'web'){
            if($user['user']->company != 1){
                return redirect()->back();
            }
            $opportunity->user_id = $user['user']->id;
        }else{
            $opportunity->company_id = $user['user']->id;
        }

        // draft
        $opportunity->is_draft = true;
        $opportunity->inactive = true;

        $opportunity->setTranslation('name', 'ka', "");
        $opportunity->setTranslation('name', 'en', "");
        $opportunity->setTranslation('description', 'ka', "");
        $opportunity->setTranslation('description', 'en', "");
        $opportunity->setTranslation('address', 'ka', "");
        $opportunity->setTranslation('address', 'en', "");
        $opportunity->latitude = "";
        $opportunity->longitude = "";
        $opportunity->min_age = null;
        $opportunity->max_age = null;
        $opportunity->phone = "";
        $opportunity->fb_page = "";
        $opportunity->linkedin_page = "";
        $opportunity->web_page = "";
        $opportunity->application_url = "";
        $opportunity->vitual_link = "";
        $opportunity->live_translation_link = "";
        $opportunity->is_virtual = false;
        $opportunity->start_date = \Carbon\Carbon::now();
        $opportunity->end_date = \Carbon\Carbon::now();
        $opportunity->schedule_date = \Carbon\Carbon::now();
        $opportunity->query_id = Query::first()->id;
        $opportunity->save();
        return $opportunity;
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pending_opportunity_attributes()
    {
        return $this->hasMany('App\PendingOpportunityAttribute');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function regions()
    {
        return $this->belongsToMany('App\Region');
    }

    public function municipalities()
    {
        return $this->belongsToMany('App\Municipality');
    }

    public function getDateString()
    {
        $opportunity = $this;

        $dateString = '';

        $startDate = \Carbon\Carbon::parse($opportunity->start_date);
        $endDate = \Carbon\Carbon::parse($opportunity->end_date);

        if ($startDate) {
            $startDateDay = $startDate->format('d');
            $startDateMonth = Month::getMonthByNumberString($startDate->format('m'));

            $dateString = $startDateDay . ' ' . $startDateMonth;

            if ($endDate && $startDate !== $endDate) {
                $endDateDay = $endDate->format('d');
                $endDateMonth = Month::getMonthByNumberString($endDate->format('m'));

                if ($endDateMonth == $startDateMonth) {
                    $dateString = $startDateDay . '-' . $endDateDay . '' . $startDateMonth;
                } else {
                    $dateString = $startDateDay . ' ' . $startDateMonth . ' - ' . $endDateDay . ' ' . $endDateMonth;
                }
            }
        }

        return $dateString;
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

    public function getShortURL()
    {
        $oppURL = str_replace(' ', '-', $this->name);
        $locale = app()->getLocale();
        if ($locale == 'ka') {
            return BaseController::$SHORT_DOMAIN . "/e/" . $this->id;
        } else {
            return BaseController::$SHORT_DOMAIN . "/" . $locale . "/e/" . $this->id;
        }
    }

    public function getURL()
    {
        $oppURL = str_replace(' ', '-', $this->name);
        $url = url('/' . app()->getLocale() . '/e/' . $this->id . '/' . $oppURL);
        return $url;
    }

    public function registerMediaConversions(Media $media = null)
    {
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('file');
    }


    // queries

    public function get_query()
    {
        return $this->belongsTo('App\Query', 'query_id');
    }

    public function questionAnswers()
    {
        return $this->hasMany('App\QueryQuestionAnswer', 'opportunity_id');
    }

    public function propertyAnswers()
    {
        return $this->hasMany('App\QueryPropertyAnswer', 'opportunity_id');
    }

    public function queryMessages()
    {
        return $this->hasMany('App\QueryMessage', 'opportunity_id');
    }

    public function queryUnattendedMessages()
    {
        return $this->hasMany('App\QueryUnattendedMessage', 'opportunity_id');
    }

    public function getQuestionAvgScore($questionId)
    {
        return $this->questionAnswers()->where('question_id', $questionId)->avg('answer');
    }

    public function getQuestionScoreAllCount($questionId)
    {
        return $this->questionAnswers()->where('question_id', $questionId)->count();
    }

    public function getQuestionScoreCount($questionId, $score)
    {
        return $this->questionAnswers()
            ->where([['question_id', $questionId], ['answer', $score]])
            ->count('answer');
    }

    public function getAllQuestionsAvgScore()
    {
        return $this->questionAnswers()->avg('answer');
    }

    public function getPropertyAnswer($propertyId)
    {
        return $this->propertyAnswers->find($propertyId)->answer;
    }

    public function getPropertiesWithCount()
    {
        return $this->query->properties->withCount(['answers' => function ($query) {
            $query->where('answer', 1);
        }]);
    }

    public function getPropertyAnswers()
    {
        return $this->propertyAnswers()->with('property')->get()->where('answer', '1')->groupby('property_id');
    }

    public function goingUsers()
    {
        return $this->belongsToMany('App\User')->withPivot(['attended', 'approved', 'random_id']);
    }

    public function goingUsersWithMessages($anonym = false)
    {
        $users = $this->goingUsers;
        $result = collect([]);
        foreach ($users as $user) {
            // Opportunity message
            $oppMessage = $user->opportunityMessage($this->id);
            if ($oppMessage) {
                if ($anonym) {
                    if (!$oppMessage->is_private) {
                        $oppMessage=null;
                    }
                } else {
                    if ($oppMessage->is_private) {
                        $oppMessage = null;
                    }
                }
            }

            // Company Message
            $compMessage = $user->opportunityCompanyMessage($this->id);
            if ($compMessage) {
                if ($anonym) {
                    if (!$compMessage->is_private) {
                        $compMessage=null;
                    }
                } else {
                    if ($compMessage->is_private) {
                        $compMessage = null;
                    }
                }
            }
            
            $res = [
                'oppMessage' => $oppMessage,
                'compMessage' => $compMessage,
                'user' => $user,
            ];
            if ($res['oppMessage'] != null || $res['compMessage'] != null) {
                $result->push($res);
            }
        }
        return $result;
    }
    public function attendedUsers()
    {
        return $this->goingUsers()->wherePivot('attended', 1)->get();
    }

    public function unattendedUsers()
    {
        return $this->goingUsers()->wherePivot('attended', 0)->get();
    }

    public function isAttended($uid)
    {
        return $this->attendedUsers()->count($uid) > 0;
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany('App\User', 'user_favorite_opportunity', 'user_id', 'opportunity_id');
    }

    public function favoriteCompanies()
    {
        return $this->belongsToMany('App\Company', 'company_favorite_opportunity', 'company_id', 'opportunity_id');
    }

    public function opportunityComments()
    {
        return $this->hasMany('App\OpportunityComment')->with('likes');
    }

    public function isFavorite($user, $id)
    {
        if (!$user) {
            return false;
        }
        $opportunity = $user->favoriteOpportunities()->find($id);
        if ($opportunity) {
            return true;
        }
        return false;
    }

    public function opportunityCommentsCount()
    {
        return $this->opportunityComments->count();
    }

    public function getNextComments($countPerPage, $seenCommentIds)
    {
        // authenticate user
        $userAuth = User::auth();
        $user = $userAuth['user'];
        $user_id = -1;
        if ($user) {
            $user_id = $user->id;
        }

        // sort given comments
        $comments = $this->opportunityComments()->with(['user', 'likes'])->get();
        $sortedCcomments = $comments->sort(function ($a, $b) use ($user_id) {
            return $a->created_at < $b->created_at;
        });

        $resultComments = [];
        $i = 0;
        foreach ($sortedCcomments as $key => $comment) {
            $i++;

            if (in_array($comment->id, $seenCommentIds)) {
                continue;
            }

            array_push($resultComments, $comment);
            array_push($seenCommentIds, $comment->id);
            if (sizeof($resultComments) >= $countPerPage) {
                break;
            }
        }

        $hasMore = true;
        if (sizeof($resultComments) < $countPerPage) {
            # if returned array size is less then asked size
            # it means we reached the end
            $hasMore = false;
        } elseif ($i == sizeof($sortedCcomments)) {
            # if array size is equal to what was given
            # but we returned last comment
            # it means we reached the end
            $hasMore = false;
        } else {
            # if neither of upper cases happend we can be at state where
            # we are left with newly added comments
            # happend when (total comments) is divisible by countPerPage and we add another comment
            $hasMore = false;
            for ($i = 0; $i < sizeof($comments); $i++) {
                if (!in_array($comments[$i]->id, $seenCommentIds)) {
                    $hasMore = true;
                    break;
                }
            }
        }

        return array(collect($resultComments), $hasMore);
    }

    public function disabilities()
    {
        return $this->belongsToMany('App\Disability');
    }


    public function opportunity_types()
    {
        $subtypes = $this->opportunity_subtypes;
        $types = collect([]);
        foreach ($subtypes as $subtype) {
            $types->push($subtype->opportunity_type->id);
        }
        return $types;
    }

    public function opportunity_subtypes()
    {
        return $this->belongsToMany('App\OpportunitySubtype');
    }

    public function faqs()
    {
        return $this->hasMany('App\FAQ');
    }

    public function opportunity_medias()
    {
        return $this->hasMany("App\OpportunityMedia");
    }
}
