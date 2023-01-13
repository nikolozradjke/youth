<?php

namespace App\Http\Controllers;

use App\Opportunity;
use App\Query;
use App\User;
use Illuminate\Http\Request;

class QueryController extends BaseController
{

    public function loadQuery(Request $request, $opportunity_id, $user_id)
    {
        // get opportunity
        $opportunity = Opportunity::where('id', $opportunity_id)->first();
        if ($opportunity == null)
            return view('query-completed', ['success' => false, 'error_msg' => 'ასეთი შესაძლებლობა არ არსებობს!']);

        // get user
        $user = User::find($user_id);
        if ($user == null)
            return view('query-completed', ['success' => false, 'error_msg' => 'ასეთი მომხმარებელი არ არსებობს!']);

        // validate token
        $true_token_value = $user->getRandomId($opportunity_id);
        
        if ($request->token == null)
        return view('query-completed', ['success' => false, 'error_msg' => 'ვალიდაციის ტოკენი არაა მითითებული!']);
        
        if ($true_token_value == null)
            return view('query-completed', ['success' => false, 'error_msg' => 'თქვენ არ გაქვთ ამ კითხვარის შევსების უფლება!']);

        if ($true_token_value != $request->token)
            return view('query-completed', ['success' => false, 'error_msg' => 'ვალიდაციის ტოკენი არასწორადაა მითითებული!']);

        // get query from opportunity
        $query = $opportunity->get_query()
            ->with(['questions', 'properties', 'unattended_questions', 'unattended_questions.options'])
            ->firstOrFail();

        return view('query', compact('query', 'opportunity_id', 'user_id'));
    }

    public function saveQuery(Request $request, $opportunity_id)
    {
        // Save Query
        $attend = $request->attend == '1' ? true : false;
        if ($attend) {
            Query::saveAttendedQuery($request, $opportunity_id);
        } else {
            Query::saveUnattendedQuery($request, $opportunity_id);
        }

        // Remove random token after query
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->removeRandomId($opportunity_id);

        // Redirect to success page
        return view('query-completed', ['success' => true]);
    }
}
