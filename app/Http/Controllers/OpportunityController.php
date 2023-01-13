<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Opportunity;
use App\OpportunityFilter;
use App\Region;
use App\User;
use Illuminate\Http\Request;
use App\Disability;
use Log;

class OpportunityController extends BaseController
{
    public function inner(Request $request, $id)
    {

        $categories = Category::withCount('opportunities')->get();
        $opportunity = Opportunity::with(['company', 'categories', 'disabilities', 'faqs'])->findOrFail($id);

        if (!$opportunity) {
            Log::info($id);
            // ToDo: Redirect to error page
        }

        $finished = $opportunity->end_date->isPast();

        $media = $opportunity->getMedia('file');

        $mediaUrls = [];

        foreach ($media as $item) {
            $mediaUrls[$item->file_name] = $item->getUrl();
        }

        //$mediaUrlString = str_replace('http:', 'https:', $mediaUrlString);

        $mediaUrlString = $opportunity->file;
        
        if(is_null($opportunity->company_id)){
            $company = $opportunity->user;
        }else{
            $company = $opportunity->company;
        }
        

        $isSubbed = false;

        $companyUsers = $company->users;
        $companyCompanies = $company->subscriberCompanies;

        $subsCount = $companyUsers->count() + $companyCompanies->count();

        $userAuth = User::auth();
        $user = $userAuth['user'];
        $guard = $userAuth['guard'];

        if ($guard == 'web') {
            $isSubbed = $companyUsers->where('id', $user->id)->count() > 0;
        } elseif ($guard == 'company') {
            $isSubbed = $companyCompanies->where('id', $user->id)->count() > 0;
        }

        $storedId = $request->input('category-id');
        $markActiveCategory = false;
        $category = null;
        if ($storedId) {
            $sessionCategoryId = intval($storedId);
            $category = Category::find($sessionCategoryId);
            $markActiveCategory = true;
        }

        $overallAverage = null;
        $questionAvgScores = [];
        $questionAllScores = [];
        $questionPropertyAnswers = [];
        $queryMessages = [];
        $queryQuestions = [];
        $query = $opportunity->get_query;
        $totalAnswerCount = [];
        $numMessagesPerPage = 4;
        $totalCount = 0;

        if ($query) {
            # all question averaged together
            $overallAverage = $opportunity->getAllQuestionsAvgScore();

            # question with it's specific average
            $queryQuestions = $query->questions;
            foreach ($queryQuestions as $question) {
                $score = $opportunity->getQuestionAvgScore($question->id);
                $totalCount += $opportunity->getQuestionScoreAllCount($question->id);
                $questionAvgScores[$question->id] = $score;
            }

            # question with it's specific answers
            foreach ($queryQuestions as $question) {
                $totalAnswerCount[$question->id] = 0;
                $questionAllScores[$question->id] = [];
                for ($i = 1; $i < 6; $i++) {
                    $count = $opportunity->getQuestionScoreCount($question->id, $i);
                    $questionAllScores[$question->id][$i] = $count;
                    $totalAnswerCount[$question->id] += $count;
                }
            }

            # count properties
            $allPropertyAnswers = $opportunity->getPropertyAnswers();
            foreach ($allPropertyAnswers as $propertyAnswers) {
                if (sizeof($propertyAnswers) > 0) {
                    $propertyAnswer = $propertyAnswers->first();
                    if ($propertyAnswer) {
                        $property = $propertyAnswer->property;
                        $questionPropertyAnswers[$property->text] = sizeof($propertyAnswers);
                    }
                }
            }

            $queryMessages = $opportunity->queryMessages()->take($numMessagesPerPage)->orderBy('created_at', 'desc')->get();
        }

        $application_url = $this->formatUrl($opportunity->application_url);
        $fb_page = $this->formatUrl($opportunity->fb_page);
        $linkedin_page = $this->formatUrl($opportunity->linkedin_page);
        $web_page = $this->formatUrl($opportunity->web_page);

        list($opportunityComments, $hasMore) = $opportunity->getNextComments(4, []);

        $totalComments = $opportunity->opportunityCommentsCount();
        $numMessages = $opportunity->queryMessages()->count();
        $interestedUsers = $opportunity->goingUsers()->count();
        $urlButtonAction = 'add-going';

        if ($user && $guard == 'web') {
            $urlButtonAction = ($user->isGoing($id) && !$application_url) ? 'remove-going' : 'add-going';
            $opportunityIsFavorite = $opportunity->isFavorite($user, $opportunity->id);
            $opportunityGoing = $user->isGoing($opportunity->id);
        } else {
            $opportunityIsFavorite = false;
            $opportunityGoing = false;
        }

        $eventDates = [
            'startTime' => [
                'date' => $opportunity['start_date']->format('d'),
                'month' => $opportunity['start_date']->format('M'),
                'year'  => $opportunity['start_date']->format('Y'),
                'time'  => $opportunity['start_date']->format('H:i')
            ],
            'endTime' => [
                'date' => $opportunity['end_date']->format('d'),
                'month' => $opportunity['end_date']->format('M'),
                'year'  => $opportunity['end_date']->format('Y'),
                'time'  => $opportunity['end_date']->format('H:i')
            ],
        ];

        return view('event-inner', [
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'has_filter' => true,
            'categories' => $categories,
            'company' => $company,
            'isSubbed' => $isSubbed,
            'subsCount' => $subsCount,
            'opportunity' => $opportunity,
            'finished' => $finished,
            'categor' => $category,
            'markActiveCategory' => $markActiveCategory,
            'mediaUrls' => $mediaUrls,
            'pagename' => 'opportunities',
            'overallAverage' => $overallAverage,
            'totalAnswerCount' => $totalAnswerCount,
            'queryQuestions' => $queryQuestions,
            'questionsAverage' => $questionAvgScores,
            'questionAllScores' => $questionAllScores,
            'questionAllScoresCount' => $totalCount,
            'opportunityComments' => $opportunityComments,
            'hasMoreComments' => $hasMore,
            'totalComments' => $totalComments,
            'queryMessages' => $queryMessages,
            'numMessagesPerPage' => $numMessagesPerPage,
            'numMessages' => $numMessages,
            'questionPropertyAnswers' => $questionPropertyAnswers,
            'og_title' => $opportunity->name,
            'og_description' => $opportunity->description,
            'og_image' => $opportunity->image,
            'urlButtonAction' => $urlButtonAction,
            'application_url' => $application_url,
            'fb_page' => $fb_page,
            'linkedin_page' => $linkedin_page,
            'web_page' => $web_page,
            'interestedUsers' => $interestedUsers,
            'opportunityIsFavorite' => $opportunityIsFavorite,
            'opportunityGoing' => $opportunityGoing,
            'eventDates' => $eventDates
        ]);
    }

    private function formatUrl($url)
    {
        if (!$url) {
            return null;
        }
        if (substr($url, 0, 7) !== "http://" && substr($url, 0, 8) !== "https://") {
            $url = "http://" . $url;
        }
        return $url;
    }

    public function filterOpportunities(Request $request)
    {
        $locale = $request->locale;
        app()->setLocale($locale);
        $numberPerPage = $request->numberPerPage;
        $page = $request->page;
        $sort = $request->sort;
        $companies = $request->filterCompanies;
        // $regions = $request->filterRegions;
        $subscribed = $request->filterSubscribed;
        $types = $request->filterTypes;
        $subtypes = $request->filterSubtypes;
        $categories = $request->filterCategories;
        $municipalities = $request->filterMunicipalities;
        $disabilities = $request->filterDisabilities;
        $minAge = $request->filterMinAge;
        $maxAge = $request->filterMaxAge;


        $type_id = $request->input('type');
        if ($type_id) {
            if (!$types)
                $types = [];
            array_push($types, $type_id);
        }
        $term = $request->term;
        $isSearch = false;

        if ($term && $term !== '') {
            $isSearch = true;
        }

        $opportunities = OpportunityFilter::filterOpportunities(
            [
                'companies'  => $companies,
                // 'regions'    => $regions,
                'types' => $types,
                'subtypes' => $subtypes,
                'categories' => $categories,
                'municipalities' => $municipalities,
                'disabilities' => $disabilities,
                'minAge' => $minAge,
                'maxAge' => $maxAge,
            ],
            $sort,
            'desc',
            $numberPerPage * ($page - 1),
            $numberPerPage,
            $isSearch,
            $subscribed
        );

        if ($isSearch) {
            $opportunities = $opportunities->where('opportunities.name', 'like', '%' . $term . '%')->get();
            $opportunityCount = OpportunityFilter::filterOpportunities(
                [
                    'companies'  => $companies,
                    // 'regions'    => $regions,
                    'types' => $types, // 0
                    'subtypes' => $subtypes, // 1
                    'categories' => $categories, // 2
                    'municipalities' => $municipalities, // 3
                    'disabilities' => $disabilities, //5
                ],
                $sort,
                'desc',
                0,
                null,
                $isSearch,
                $subscribed
            )->where('opportunities.name', 'like', '%' . $term . '%')->count();
        } else {
            $opportunityCount = OpportunityFilter::filterOpportunities(
                [
                    'companies'  => $companies,
                    // 'regions'    => $regions,
                    'types' => $types, // 0
                    'subtypes' => $subtypes, // 1
                    'categories' => $categories, // 2
                    'municipalities' => $municipalities, // 3
                    'disabilities' => $disabilities, //5
                ],
                $sort,
                'desc',
                0,
                null,
                $isSearch,
                $subscribed
            )->count();
        }


        return response()->json([
            'opportunities' => view('renders.opportunitiesRender', [
                'opportunities' => $opportunities
            ])->render(),
            'pagination'    => view('renders.paginationRender', [
                'opportunityCount' => $opportunityCount,
                'numberPerPage'    => $numberPerPage,
                'page'             => $page,
                'term'             => $term
            ])->render(),
            'count' => $opportunityCount
        ]);
    }

    public function all(Request $request)
    {
        $type_id = $request->input('type');
        $filter_arr = [];
        if ($type_id)
            $filter_arr['types'] = [$type_id];

        $numberPerPage = 9;
        $page = 1;
        if (request()->filled('page')) {
            $page = request()->page;
            $page = max($page, 1);
        }
        $opportunities = OpportunityFilter::filterOpportunities($filter_arr, 'schedule_date', 'desc', ($page - 1) * $numberPerPage, $numberPerPage);
        $opportunityCount = OpportunityFilter::filterOpportunities($filter_arr, 'schedule_date', 'desc', 0, null)->count();

        $categories = Category::withCount('opportunities')->get();
        $regions = Region::withCount('opportunities')->get();
        $companies = Company::where('approved', 1)->get();
        $disabilities = Disability::all();

        $user = null;
        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }

        if ($user && $guard == 'web') {
            foreach ($opportunities as $opportunity) {
                if ($user->isFavorite($opportunity->id)) {
                    $opportunity->favorite = true;
                } else {
                    $opportunity->favorite = false;
                }
            }
        }

        return view('opportunities', [
            'pagename' => 'opportunities',
            'has_filter' => true,
            'dropdownFilters' => true,
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'opportunityCount' => $opportunityCount,
            'opportunities' => $opportunities,
            'numberPerPage' => $numberPerPage,
            'page' => $page,
            'type_id' => $type_id,
            'disabilities' => $disabilities,
        ]);
    }

    public function userOpportunities()
    {

        $numberPerPage = 9;
        $page = 1;

        $categories = Category::withCount('opportunities')->get();
        $regions = Region::withCount('opportunities')->get();
        $companies = Company::where('approved', 1)->get();

        $user = null;

        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }

        $userCategories = $user->categories->pluck('id')->toArray();

        if ($guard == 'web') {
            $userCompanies = $user->companies->pluck('id')->toArray();
        } else {
            $userCompanies = $user->subscribedCompanies->pluck('id')->toArray();
        }

        $opportunities = OpportunityFilter::filterOpportunities(
            [
                'companies' => $userCompanies,
                'categories' => $userCategories,
            ],
            'schedule_date',
            'desc',
            $numberPerPage * ($page - 1),
            $numberPerPage,
            false,
            true
        );

        $opportunityCount = OpportunityFilter::filterOpportunities(
            [
                'companies' => $userCompanies,
                'categories' => $userCategories,
            ],
            'schedule_date',
            'desc',
            $numberPerPage * ($page - 1),
            null,
            false,
            true
        )->count();

        return view('opportunities', [
            'has_filter' => true,
            'dropdownFilters' => true,
            'auth' => $user !== null,
            'subscribeQuery' => true,
            'user' => $user,
            'guard' => $guard,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'opportunities' => $opportunities,
            'numberPerPage' => $numberPerPage,
            'page' => $page,
            'opportunityCount' => $opportunityCount,
            'pagename' => 'opportunities',
            'userCompanies' => $userCompanies,
        ]);
    }

    public function addToFavorites(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {
            $status = 'error';
            $message = 'This opportunity already is a favorite';
            if ($user->addFavoriteOpportunity($id)) {
                $status = 'success';
                $message = 'The opportunity has been added to favorites';
            }

            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function removeFromFavorites(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {
            $user->removeFavoriteOpportunity($id);

            return response()->json([
                'status' => 'success',
                'message' => 'The opportunity has been removed from favorites'
            ]);
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function isFavorite(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {

            $res = $opportunity->isFavorite($user, $id);

            return response()->json(
                [
                    'status' => 'success',
                    'result' => $res,
                ]
            );
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function addToGoings(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {
            $status = 'error';
            $message = 'This opportunity already is added';
            if ($user->addGoingOpportunity($id)) {
                $status = 'success';
                $message = 'The opportunity has been marked as going';
            }

            return response()->json(
                [
                    'status' => $status,
                    'message' => $message,
                ]
            );
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function removeFromGoings(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {
            $user->removeGoingOpportunity($id);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'The opportunity has been unmarked as going',
                ]
            );
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function isGoing(Request $request)
    {
        $id = $request->id;
        $user = User::auth()['user'];

        if ($user) {

            $opportunity = Opportunity::find($id);

            $res = $opportunity->isGoing($user->id);

            return response()->json([
                'status' => 'success',
                'result' => $res
            ]);
        };

        return response()->json([
            'status' => 'error',
            'message' => 'User has to be logged in',
        ]);
    }

    public function paginateFeedback(Request $request)
    {
        $numberPerPage = $request->numberPerPage;
        $page = $request->page;
        $opportunityID = $request->opportunityID;

        $offset = ($page - 1) * $numberPerPage;
        $opportunity = Opportunity::find($opportunityID);
        if ($opportunity) {
            $feedbacks = $opportunity->queryMessages()->offset($offset)->limit($numberPerPage)->get();
            return response()->json([
                'feedback' => view('renders.feedbackRender', [
                    'messages' => $feedbacks,
                ])->render(),
                'feedbackCount' => $feedbacks->count(),
            ]);
        }
        return response()->json(['error' => 'something went wrong']);
    }

    public function paginateComments(Request $request)
    {
        $user = null;

        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
        }

        $numberPerPage = 4;
        $allCommentsIds = $request->current_comment_ids;
        $opportunityID = $request->opportunity_id;

        $opportunity = Opportunity::where('id', $opportunityID)->first();

        list($comments, $hasMore) = $opportunity->getNextComments($numberPerPage, $allCommentsIds);

        return response()->json([
            'comments' => $comments->map(function ($item) use ($user, $guard) {
                return view('renders.opportunityCommentRender', [
                    'comment' => $item,
                    'auth'  => $user !== null,
                    'user' => $user,
                    'guard' => $guard
                ])->render();
            }),
            'hasMore' => $hasMore,
        ]);
    }

    public function innerRedirect(Request $request, $id)
    {
        $opportunity = Opportunity::where('id', $id)->first();
        $url = str_replace(' ', '-', $opportunity->name);
        if (strlen($url) == 0)
            $url =  "Temp";
        return redirect($request->path() . '/' . $url);
    }
}
