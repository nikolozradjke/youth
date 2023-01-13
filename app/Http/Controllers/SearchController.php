<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opportunity;
use App\OpportunityFilter;
use App\Company;
use App\Category;
use App\Region;

class SearchController extends BaseController
{
    public function search(Request $request)
    {

        $numberPerPage = 9;
        $page = 1;

        $companyNumberPerPage = 16;

        $term = $request->text;
        //dd(OpportunityFilter::filterOpportunities([], 'schedule_date', 'desc', 0, 9, true)->where('opportunities.name', 'like', '%' . $term . '%')->toSql());
        // $opportunities = OpportunityFilter::filterOpportunities([], 'schedule_date', 'desc', 0, 9, true)->where('opportunities.name', 'like', '%' . $term . '%')->get();
        $opportunities = Opportunity::where('opportunities.name', 'like', '%' . $term . '%')->where('inactive', 0)->whereRaw('schedule_date <= NOW()')->where('is_draft', 0)->get();
        
        // $opportunityCount = OpportunityFilter::filterOpportunities([], 'schedule_date', 'desc', 0, 9, true)->where('opportunities.name', 'like', '%' . $term . '%')->count();
        $opportunityCount = Opportunity::where('opportunities.name', 'like', '%' . $term . '%')->where('inactive', 0)->whereRaw('schedule_date <= NOW()')->where('is_draft', 0)->count();

        $searchCompanies = Company::where('name', 'like', '%' . $term . '%')->where('approved', 1)->take($companyNumberPerPage)->get();
        $companyCount = Company::where('name', 'like', '%' . $term . '%')->where('approved', 1)->count();

        $user = null;

        $guard = 'web';

        if(auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';

        }
        elseif(auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }

        $categories = Category::withCount('opportunities')->get();
        $regions    = Region::withCount('opportunities')->get();
        $companies  = Company::where('approved', 1)->get();

        return view('search', [
            'term' => $term,
            'has_filter' => true,
            'dropdownFilters' => true,
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'opportunities' => $opportunities,
            'opportunityCount' => $opportunityCount,
            'searchCompanies' => $searchCompanies,
            'companyNumberPerPage' => $companyNumberPerPage,
            'companyCount' => $companyCount,
            'numberPerPage' => $numberPerPage,
            'page' => $page,
            'pagename' => 'opportunities'
        ]);
    }
}
