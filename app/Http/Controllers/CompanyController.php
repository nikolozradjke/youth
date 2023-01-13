<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\OpportunityFilter;
use App\Category;
use App\CompanyFilter;
use App\QueryOpportunityProperty;
use App\QueryQuestion;

class CompanyController extends BaseController
{

    public function filter()
    {
        $args = [
            'registration' => [
                'regions' => [2],
                'municipalities' => [1]
            ]
        ];

        $companies = CompanyFilter::filterCompanies($args);
        dd($companies);
    }

    public function inner($id)
    {
        $page = request()->input('page');

        if (!$page) {
            $page = 1;
        }

        $numberPerPage = 9;

        $company = Company::find($id);

        $categories = Category::withCount('opportunities')->get();

        $companyUsers = $company->users;

        $companyCompanies = $company->subscriberCompanies;

        $subsCount = $companyUsers->count() + $companyCompanies->count();

        $isSubbed = false;

        $user = null;

        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
            $isSubbed = $companyUsers->where('id', $user->id)->count() > 0;
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
            $isSubbed = $companyCompanies->where('id', $user->id)->count() > 0;
        }

        $companyOpportunities = OpportunityFilter::filterOpportunities(
            [
                'companies'  => [$company->id]
            ],
            'schedule_date',
            'desc',
            $numberPerPage * ($page - 1),
            $numberPerPage
        );

        $opportunityCount = $company->opportunities->count();

        list($feedbacks, $hasMoreFeeds) = $company->get_next_feedbacks();

        $ongoingOpportunities = $company->ongoingOpportunities;
        $finishedOpportunities = $company->finishedOpportunities;

        $queryAnswers = $company->companyOpportunitiesAnswers;
        $propertyAnswers = $company->companyOpportunitiesPropertiesAnswersYes;

        $propertyClasifiedAnswers = [];
        foreach ($propertyAnswers as $answer) {
            if (!array_key_exists($answer->property_id, $propertyClasifiedAnswers))
                $propertyClasifiedAnswers[$answer->property_id] = 0;
            $propertyClasifiedAnswers[$answer->property_id]++;
        }
        $queryProperties = QueryOpportunityProperty::all();

        $queryQuestions = QueryQuestion::all();
        $queryQuestionAnswersDetailed = [];
        foreach ($queryQuestions as $key => $value) {
            $curQuestAnswers = $company->companyGetAnswersByQuestionId($value->id)->get();
            $queryQuestionAnswersDetailed[$value->id] =
                [
                    'votes' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
                    'question' => $queryQuestions[$key],
                    'avg' => $company->companyGetAnswersAvgByQuestionId($value->id),
                    'total' => $curQuestAnswers->count(),
                ];

            for ($i = 1; $i <= 5; $i++) {
                $curAns = $curQuestAnswers->filter(function ($value, $key) use ($i) {
                    return $value->answer == $i;
                });
                $queryQuestionAnswersDetailed[$value->id]['votes'][$i] = $curAns->count();
            }
        }
        return view('organization', [
            'categories' => $categories,
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'has_filter' => true,
            'company' => $company,
            'subsCount' => $subsCount,
            'isSubbed' => $isSubbed,
            'opportunities' => $companyOpportunities,
            'opportunityCount' => $opportunityCount,
            'numberPerPage' => $numberPerPage,
            'page' => $page,
            'pagename' => 'organization',
            'og_title' => $company->name,
            'og_description' => $company->description1,
            'og_image' => $company->image,
            'fb_page' => $company->fb_page,
            'web_page' => $company->web_page,
            'ln_page' => $company->linkedin_page,
            'feedbacks' => $feedbacks,
            'hasMoreFeeds' => $hasMoreFeeds,
            'ongoingOpportunities' => $ongoingOpportunities,
            'finishedOpportunities' => $finishedOpportunities,
            'queryAnswers' => $queryAnswers,
            'queryPropertyAnswers' => $propertyClasifiedAnswers,
            'queryProperties' => $queryProperties,
            'queryQuestionAnswersDetailed' => $queryQuestionAnswersDetailed,
        ]);
    }

    public function filterCompanies(Request $request)
    {
        $locale = $request->locale;
        app()->setLocale($locale);
        $numberPerPage = $request->numberPerPage;
        $page = $request->page;
        $term = $request->term;

        $filters = [
            'companyStatuses' => $request->filterByCompanyStatuses,
            'companyWorkingType' => $request->filterByCompanyWorkingType,
            'companyTypes' => $request->filterByCompanyTypes,
            'registrationMunicipalities' => $request->filterByRegistrationMunicipalities,
            'workingMunicipalities' => $request->filterByWorkingMunicipalities,
        ];
        $companies = CompanyFilter::filterCompanies(
            $filters,
            'create_date',
            'desc',
            $numberPerPage * ($page - 1),
            $numberPerPage,
            false
        );
        $companyCount = sizeof(CompanyFilter::filterCompanies($filters, null, 'desc', 0, null, false));
        return response()->json([
            'companies' => view('templates.organizations', [
                'companies' => $companies
            ])->render(),
            'pagination'    => view('renders.paginationRender', [
                'opportunityCount' => $companyCount,
                'numberPerPage'    => $numberPerPage,
                'page'             => $page,
                'term'             => $term
            ])->render(),
            'count' => $companyCount,
        ]);
    }

    public function all()
    {
        $numberPerPage = 9;
        $page = 1;
        if (request()->filled('page')) {
            $page = request()->page;
            $page = max($page, 1);
        }

        $user = null;

        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }
        $companies = CompanyFilter::filterCompanies([], 'create_date', 'desc', ($page - 1) * $numberPerPage, $numberPerPage, false);
        $companyCount = CompanyFilter::filterCompanies([], 'create_date', 'desc', 0, null)->count();
        return view('organizations-all', [
            'pagename' => 'organizations',
            'dropdownFilters' => true,
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'companies' => $companies,
            'numberPerPage' => $numberPerPage,
            'companyCount' => $companyCount,
            'page' => $page
        ]);
    }

    public function innerRedirect(Request $request, $id)
    {
        $company = Company::where('id', 1)->first();
        $url = str_replace(' ', '-', $company->name);
        
        return redirect($request->path() . '/' . $url);
    }

    public function paginateFeedbacks(Request $request)
    {
        $companyID = $request->company_id;
        $count = $request->count;
        $company = Company::where('id', $companyID)->first();
        list($feedbacks, $hasMore) = $company->get_next_feedbacks($count, 4);

        return response()->json([
            'feedbacks' => $feedbacks->map(function ($item) {
                return view('renders.organizationFeedbackRenderer', [
                    'feedback' => $item,
                ])->render();
            }),
            'hasMore' => $hasMore,
        ]);
    }
}
