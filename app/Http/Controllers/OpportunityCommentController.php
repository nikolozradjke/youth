<?php

namespace App\Http\Controllers;

use App\OpportunityComment;
use App\User;
use App\OpportunityCommentLike;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OpportunityCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = User::auth();
        $user = $auth['user'];
        $guard = $auth['guard'];

        $comment = OpportunityComment::create([
            'text' => $request->text,
            'user_id' => $user->id,
            'opportunity_id' => $request->opportunity_id,
        ]);

        return response()->json([
            'comment' => view('renders.opportunityCommentRender', [
                'comment' => $comment,
                'auth'  => $user !== null,
                'user' => $user,
                'guard' => $guard
            ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OpportunityComment  $opportunityComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get by id
        $opportunityComment = OpportunityComment::find($id);

        // update
        $opportunityComment->text = $request->text;

        // store
        $opportunityComment->save();
        return $opportunityComment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OpportunityComment  $opportunityComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $opportunityComment = OpportunityComment::destroy($request->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $auth = User::auth();
        $user = $auth['user'];
        $guard = $auth['guard'];
        if($user == null)
            return response('Not Logged In!', 401);

        $opportunity_comment_id = $request->opportunity_comment_id;
        $like = $request->like == '1' ? true : false;
        $opportunityCommentLike = OpportunityCommentLike::where([
                ['opportunity_comment_id', $opportunity_comment_id],
                ['user_id', $user->id],
                ['user_type', $guard]
            ])
            ->first();
        
        if ($opportunityCommentLike) {
            // Case 1:  if like record exists
            if ($opportunityCommentLike->like == $like) {
                // case 1.1: if exists and clicked on the same like again
                // should delete current vote
                $opportunityCommentLike->delete();
            } else {
                // case 1.2: if exists and clicked on the oposite
                // should update record to opposite of current like
                $opportunityCommentLike->like = $like;
                $opportunityCommentLike->save();
            }
        } else {
            // case 2: if doesn't exists just add new record
            OpportunityCommentLike::create([
                'opportunity_comment_id' => $opportunity_comment_id,
                'user_id' => $user->id,
                'like' => $like,
                'user_type' =>$guard,
            ]);
        }
    }
}
