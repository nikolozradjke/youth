<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Month;

class QueryMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'opportunity_id', 'company_id', 'company_opportunity_id', 'message', 'is_private', 'likes', 'dislikes'
    ];

    public function getDateString()
    {
        $date = $this->created_at->format('d-m-y');
        $month = $this->created_at->format('m');
        return str_replace('-' . $month . '-', '-' . Month::getMonthByNumberString($month) . '-', $date);
    }

    public function getUserName()
    {
        if($this->is_private)
        {
            return 'ანონიმური';
        }
        if(!$this->user) {
            return 'გაუქმებულია გაუქმებულია';
        }
        return $this->user->first_name . ' ' .  $this->user->last_name;
    }

    public function getUserPicture()
    {
        if($this->is_private)
        {
            return 'images/default-avatar.png';
        }
        if(!$this->user) {
            return null;
        }
        return $this->user->getImagePath();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Opportunity', 'opportunity_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function interactedUsers()
    {
        return $this->belongsToMany('App\User')->withPivot('delta');
    }

    public function likedUsers()
    {
        return $this->interactedUsers()->wherePivot('delta', 1)->get();
    }

    public function dislikedUsers()
    {
        return $this->interactedUsers()->wherePivot('delta', 0)->get();
    }

    // liked == 1: check if the user has liked
    // liked == 0: check if the user has disliked
    public function isLikedUser($liked)
    {
        $userInfo = User::auth();
        if($userInfo['user'] && $userInfo['guard'] == 'web')
        {
            if($this->interactedUsers()->wherePivot('delta', $liked)->where('user_id', $userInfo['user']->id)->first())
            {
                return true;
            }
        }
        return false;
    }

    public function likeUser($id, $isLike)
    {
        $this->interactedUsers()->detach($id);
        if($isLike >= 0)
        {
            $this->interactedUsers()->attach($id, ['delta' => $isLike]);
        }
    }
}
