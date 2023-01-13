<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Region;
use App\Company;
use App\OpportunityFilter;

class CategoryController extends BaseController
{
    public function category($id)
    {
        $regions = Region::all();
        $companies = Company::where('approved', 1)->get();

        $categories = Category::withCount('opportunities')->get();
        $category = Category::find($id);
        $numberPerPage = 9;

        $opportunities = OpportunityFilter::filterOpportunities(
            [
                'categories'  => [$category->id]
            ],
            'schedule_date',
            'desc',
            0,
            $numberPerPage
        );

        $user = auth()->guard('web')->user();
        $guard = 'web';
        if(!$user) {
            $guard = 'company';
            $user = auth()->guard('company')->user();
        }

        return view('opportunities', [
            'auth' => $user !== null,
            'has_filter' => true,
            'dropdownFilters' => true,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'user' => $user,
            'guard' => $guard,
            'title' => $category->name,
            'opportunities' => $opportunities,
            'opportunityCount' => $category->getOpportunityCount(),
            'numberPerPage' => $numberPerPage,
            'category' => $category,
            'markActiveCategory' => true,
            'page' => 1,
            'showSubButton' => true,
        ]);
    }
}
