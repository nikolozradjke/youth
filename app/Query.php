<?php

namespace App;

use App\Opportunity;
use App\QueryUnattendedMessage;
use App\QueryUnattendedQuestionAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class Query extends Model
{
    use HasTranslations;

    protected $translatable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public static function saveUnattendedQuery(Request $request, $opportunity_id)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        QueryUnattendedQuestionAnswer::create([
            'user_id' => $user_id,
            'opportunity_id' => $opportunity_id,
            'question_id' => $request["question_id"],
            'option_id' => $request["option_id"],
            'text' => $request["text"],
        ]);

        if ($request['feedback']) {
            QueryUnattendedMessage::create([
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id,
                'message' => $request['feedback'],
                'is_private' => $request->has('no_anonym') ? false : true,
            ]);
        }
        $user->goingOpportunities()->updateExistingPivot($opportunity_id, ['attended' => 0]);
    }

    public static function saveAttendedQuery(Request $request, $opportunity_id)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        foreach ($request->answers as $question_id => $answer) {
            QueryQuestionAnswer::create([
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id,
                'question_id' => $question_id,
                'answer' => $answer,
            ]);
        }

        $all_properties = $request->all_properties;
        $checked_properties = $request->checked_properties;
        if (!$checked_properties)
            $checked_properties = [];
        foreach ($all_properties as $prop_id) {
            QueryPropertyAnswer::create([
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id,
                'property_id' => $prop_id,
                'answer' => in_array($prop_id, $checked_properties),
            ]);
        }
        if ($request->feedback_oppurtunity) {
            QueryMessage::create([
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id,
                'message' => $request->feedback_oppurtunity,
                'likes' => 0,
                'dislikes' => 0,
                'is_private' => $request->has('no_anonym_opportunity') ? false : true,
            ]);
        }
        if ($request->feedback_company) {
            QueryMessage::create([
                'user_id' => $user_id,
                'company_id' => Opportunity::find($opportunity_id)->company_id,
                'company_opportunity_id' => $opportunity_id,
                'message' => $request->feedback_company,
                'likes' => 0,
                'dislikes' => 0,
                'is_private' => $request->has('no_anonym_company') ? false : true,
            ]);
        }
        $user->goingOpportunities()->updateExistingPivot($opportunity_id, ['attended' => 1]);
    }

    public function opportunities()
    {
        return $this->hasMany('App\Opportunity');
    }

    public function questions()
    {
        return $this->belongsToMany('App\QueryQuestion')->withPivot('order');
    }

    public function properties()
    {
        return $this->belongsToMany('App\QueryOpportunityProperty')->withPivot('order');
    }

    public function unattended_questions()
    {
        return $this->belongsToMany('App\QueryUnattendedQuestion', 'query_query_unattended_question', 'query_id', 'question_id');
    }
}
