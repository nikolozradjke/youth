<?php

namespace App;

use App\OpportunityComment;
use App\User;
use App\Company;
use Illuminate\Database\Eloquent\Model;

class OpportunityCommentLike extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'opportunity_comment_id', 'user_id', 'like', 'user_type'
    ];

    /**
     * Get the user that owns the like.
     */
    public function user()
    {
        if($this->user_type == 'user')
            return $this->belongsTo(User::class, 'user_id');
        else
            return $this->belongsTo(Company::class, 'user_id');
    }

    /**
     * Get the opportunity comment that owns the like.
     */
    public function comment()
    {
        return $this->belongsTo(OpportunityComment::class, 'opportunity_comment_id');
    }
}
