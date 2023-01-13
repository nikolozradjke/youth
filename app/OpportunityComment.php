<?php

namespace App;

use App\Opportunity;
use App\OpportunityCommentLike;
use App\User;
use Illuminate\Database\Eloquent\Model;

class OpportunityComment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'user_id', 'opportunity_id',
    ];

    private $months = [
        '01' => 'იან',
        '02' => 'თებ',
        '03' => 'მარ',
        '04' => 'აპრ',
        '05' => 'მაი',
        '06' => 'ივნ',
        '07' => 'ივლ',
        '08' => 'აგვ',
        '09' => 'სექ',
        '10' => 'ოქტ',
        '11' => 'ნოე',
        '12' => 'დეკ',
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the opportunity that owns the comment.
     */

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    /**
     * Get the likes for the comment.
     */
    public function likes()
    {
        return $this->hasMany(OpportunityCommentLike::class);
    }

    /**
     * Get the likes count which are upvoted
     */
    public function upVotesCount()
    {
        return $this->likes()->where('like', true)->count();
    }

    /**
     * Get the likes count which are downvoted
     */
    public function downVotesCount()
    {
        return $this->likes()->where('like', false)->count();
    }

    /**
     * Get the likes count which are upvoted
     */
    public function upVotesUsers($type)
    {
        return $this->likes()->where([['like', true],['user_type', $type]])->get()->map(function ($like) {
            return $like->user_id;
        });

    }

    /**
     * Get the likes count which are downvoted
     */
    public function downVotesUsers($type)
    {
        return $this->likes()->where([['like', false],['user_type', $type]])->get()->map(function ($like) {
            return $like->user_id;
        });
    }

    /**
     * Get the creation date in string format
     */
    public function getDateString()
    {
        // get and parse date from database
        $createDate = \Carbon\Carbon::parse($this->created_at);

        // extract day/month/year
        $createDateDay = $createDate->format('d');
        $createDateMonth = $this->months[$createDate->format('m')];
        $createDateYear = $createDate->format('y');

        // join and get final string
        $dateString = $createDateDay . '-' . $createDateMonth . '-' . $createDateYear;

        return $dateString;
    }

}
