<?php

namespace App\Http\Controllers;

use App\PlaceOfResidence;
use App\Region;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Opportunity;
use App\UserOcupationWork;
use App\UserDisability;
use App\UserEducation;
use App\UserOccupation;
use App\UserOcupationStudy;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use ImageOptimizer;
use Illuminate\Database\Eloquent\Builder;

class UserController extends BaseController
{
    public function profilePage()
    {
        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        $favoriteOpportunitiesPerPage = 9;
        // ->whereRaw('end_date >= CURDATE()')
        $favoriteOpportunities = $user->favoriteOpportunities()->with('company')->take($favoriteOpportunitiesPerPage)->get();
        $favoriteOpportunitiesCount = $user->favoriteOpportunities()->whereRaw('end_date >= CURDATE()')->count();

        $goingOpportunitiesPerPage = 9;
        $goingOpportunities = collect();
        $goingOpportunitiesCount = 0;

        $companiesPerPage = 9;
        $companyCount = 0;
        $userCompanies = null;

        $categoriesPerPage = 9;
        $categoryCount = 0;
        $userCategories = null;

        if ($guard == 'web') {
            $userCompanies = $user->companies()->withCount(['users', 'subscriberCompanies'])->take($companiesPerPage)->get();
            $companyCount = $user->companies()->count();

            $userCategories = $user->categories()->take($categoriesPerPage)->get();
            $categoryCount = $user->categories()->count();

            $goingOpportunitiesPerPage = 9;
            $goingOpportunities = $user->goingOpportunities()->with('company')->whereRaw('end_date >= CURDATE()')->take($goingOpportunitiesPerPage)->get();
            $goingOpportunitiesCount = $user->goingOpportunities()->whereRaw('end_date >= CURDATE()')->count();

            $finishedOpportunities = Opportunity::whereRaw('end_date < CURDATE()')->where(function ($q) use ($user) {
                $q->whereHas('favoriteUsers', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                })->orWhereHas('goingUsers', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })->with('company');
        } elseif ($guard == 'company') {
            $userCategories = $user->subscribedCategories;
            $userCompanies = $user->subscribedCompanies()->withCount(['users', 'subscriberCompanies'])->get();

            $finishedOpportunities = Opportunity::whereRaw('end_date < CURDATE()')->where(function ($q) use ($user) {
                $q->whereHas('favoriteUsers', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })->with('company');
        }

        $finishedOpportunitiesPerPage = 9;
        $finishedOpportunitiesCount = $finishedOpportunities->count();
        $finishedOpportunities = $finishedOpportunities->take($finishedOpportunitiesPerPage)->get();

        $tab = request()->tab;
        $userDisabilities = UserDisability::all();
        $userOccupation = UserOccupation::all();
        $userOcupationWork = UserOcupationWork::all();
        $userOcupationStudy = UserOcupationStudy::all();
        $userEducation = UserEducation::all();

        $regions = Region::with('municipalities')->get();

        // Default place of registration
        $residence = new PlaceOfResidence();
        return view('profile', [
            'pagename' => 'profile',
            'auth' => true,
            'user' => $user,
            'guard' => $guard,
            'companiesPerPage' => $companiesPerPage,
            'companyCount' => $companyCount,
            'userCompanies' => $userCompanies,
            'categoryCount' => $categoryCount,
            'categoriesPerPage' => $categoriesPerPage,
            'categories' => $userCategories,
            'tab' => $tab,
            'goingOpportunitiesPerPage' => $goingOpportunitiesPerPage,
            'goingOpportunities' => $goingOpportunities,
            'goingOpportunitiesCount' => $goingOpportunitiesCount,
            'favoriteOpportunitiesPerPage' => $favoriteOpportunitiesPerPage,
            'favoriteOpportunities' => $favoriteOpportunities,
            'favoriteOpportunitiesCount' => $favoriteOpportunitiesCount,
            'finishedOpportunitiesPerPage' => $finishedOpportunitiesPerPage,
            'finishedOpportunities' => $finishedOpportunities,
            'finishedOpportunitiesCount' => $finishedOpportunitiesCount,
            'userDisabilities' => $userDisabilities,
            'userOccupation' => $userOccupation,
            'userOcupationWork' => $userOcupationWork,
            'userOcupationStudy' => $userOcupationStudy,
            'userEducation' => $userEducation,
            'regions' => $regions,
            'residence' => $residence,
        ]);
    }

    public function editUserInfo(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'private_number' => 'nullable|digits:11',
            'email' => 'required',
            'gender' => 'nullable|string'
        ]);

        //dd($validatedData);

        $user = auth()->guard('web')->user();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if ($request->birth_date) {
            $user->birth_date = \Carbon\Carbon::parse($request->birth_date)->format('Y-m-d');
        } else {
            $user->birth_date = null;
        }
        $user->private_number = $request->private_number;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->is_complete = true;
        $user->gender = $request->gender;

        if (isset($request->gender)) {
            $user->gender = $request->gender;
        } else {
            $user->gender = null;
        }

        $user->update();

        return redirect()->route('profile', ["tab"=>"private-info"])->with(['update_status' => 'success', 'message' => 'web.user.update_success']);
    }

    public function editUserInfoDisabilities(Request $request)
    {
        $user = auth()->guard('web')->user();

        $userDisabilities = $request->disabilities;
        $user->userDisabilities()->detach();
        if ($userDisabilities) {
            foreach ($userDisabilities as $disability_id) {
                $user->userDisabilities()->attach($disability_id);
            }
        }
        $user->update();

        return redirect()->route('profile', ["tab"=>"disabilities"])->with(['update_status' => 'success', 'message' => 'web.user.update_success']);
    }

    public function editUserInfoOccupations(Request $request)
    {
        $user = auth()->guard('web')->user();

        // Update fields
        $user->user_ocupation_study_id = $request->userOcupationStudy;
        $user->user_ocupation_work_id = $request->userOcupationWork;
        $user->user_occupation_id = $request->userOccupation;
        $user->ocupation_description = $request->ocupation_description;

        $user->update();

        return redirect()->route('profile', ["tab"=>"education"])->with(['update_status' => 'success', 'message' => 'web.user.update_success']);
    }

    public function editUserInfoEducation(Request $request)
    {
        $user = auth()->guard('web')->user();

        $userEducations = $user->userEducations();

        $userEducations->detach();
        $user->currently_studying = null;
        if (!$request->no_study) {
            $userEducations->attach($request->education_id);
            $user->currently_studying = $request->user_education_description;
        }

        $user->update();
        return redirect()->route('profile', ["tab"=>"education"])->with(['update_status' => 'success', 'message' => 'web.user.update_success']);
    }

    public function editUserInfoResidence(Request $request)
    {
        $user = auth()->guard('web')->user();
        // dd($user->place_of_residence);
        $request->user_id = $user->id;
        $validatedData = $request->validate([
            'is_georgia' => 'required',
            'address_text' => 'required',
            'region_id' => 'nullable',
            'municipality_id' => 'nullable',
        ]);
        if ($user->place_of_residence) {
            $user->place_of_residence->update($validatedData);
        } else {
            // Place of Residence
            PlaceOfResidence::create([
                'is_georgia' => $request->is_georgia,
                'address_text' => $request->address_text,
                'user_id' => $user->id,
                'region_id' => $request->region,
                'municipality_id' => $request->municipality,
            ]);
        }
        $user->update();
        return redirect()->route('profile', ["tab"=>"address"])->with(['update_status' => 'success', 'message' => 'web.user.update_success']);
    }

    public function editUserPassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
        }


        $hasher = app('hash');
        if ($hasher->check($request->old_password, $user->password)) {

            $user->password = bcrypt($request->password);

            $user->update();

            return redirect()->back()->withInput(["tab"=>"password"])->with(['update_status' => 'success', 'message' => 'web.user.password_success']);
        }
        return back()->withErrors(['password' => 'errors.password.incorrect']);
    }

    public function updatePicture(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);

        $image = $request->image;

        $folderName = 'user_images';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
        } elseif (auth()->guard('company')->check()) {
            $folderName = 'company_images';
            $user = auth()->guard('company')->user();
        }

        $imagePath = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store($folderName, 'public');
            $imagePath = '/storage/' . $imagePath;
        }

        Storage::delete($user->image);

        $user->image = $imagePath;
        $user->update();

        ImageOptimizer::optimize(public_path($user->image));

        return redirect()->route('profile');
    }

    public function likeFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'query_message_id' => 'required',
            'is_like' => 'required'
        ]);

        $id = intval($request->query_message_id);
        $isLike = intval($request->is_like);
        $user = User::auth()['user'];

        $user->likeQueryMessage($id, $isLike);

        return response()->json(['status' => 'success']);
    }

    public function paginateSubscribedCompanies(Request $request)
    {
        $validatedData = $request->validate([
            'page' => 'required',
            'perPage' => 'required'
        ]);

        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        if ($user) {
            $numberPerPage = $request->perPage;
            $page = $request->page;
            $companies = $user->subscribedCompanies()->withCount(['users', 'subscriberCompanies'])->skip(($page - 1) * $numberPerPage)->take($numberPerPage)->get();
            $companyCount = $user->subscribedCompanies()->count();

            return response()->json([
                'opportunities' => view('renders.subscribedCompaniesRender', [
                    'companies' => $companies,
                ])->render(),
                'pagination' => view('renders.paginationRender', [
                    'opportunityCount' => $companyCount,
                    'numberPerPage' => $numberPerPage,
                    'page' => $page,
                    'term' => '',
                ])->render(),
            ]);
        }
    }

    public function paginateSubscribedCategories(Request $request)
    {
        $validatedData = $request->validate([
            'page' => 'required',
            'perPage' => 'required'
        ]);

        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        if ($user) {
            $numberPerPage = $request->perPage;
            $page = $request->page;
            $categories = $user->subscribedCategories()->skip(($page - 1) * $numberPerPage)->take($numberPerPage)->get();
            $categoryCount = $user->subscribedCategories()->count();

            return response()->json([
                'opportunities' => view('renders.subscribedCategoriesRender', [
                    'categories' => $categories,
                ])->render(),
                'pagination' => view('renders.paginationRender', [
                    'opportunityCount' => $categoryCount,
                    'numberPerPage' => $numberPerPage,
                    'page' => $page,
                    'term' => '',
                ])->render(),
            ]);
        }
    }

    public function paginateGoingOpportunities(Request $request)
    {
        $validatedData = $request->validate([
            'page' => 'required',
            'perPage' => 'required'
        ]);

        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        if ($user && $guard == 'web') {
            $numberPerPage = $request->perPage;
            $page = $request->page;
            $opportunities = $user->goingOpportunities()->with('company')->whereRaw('start_date >= CURDATE()')->skip(($page - 1) * $numberPerPage)->take($numberPerPage)->get();
            $opportunityCount = $user->goingOpportunities()->whereRaw('start_date >= CURDATE()')->count();

            return response()->json([
                'opportunities' => view('renders.profileOpportunitiesRender', [
                    'opportunities' => $opportunities,
                ])->render(),
                'pagination' => view('renders.paginationRender', [
                    'opportunityCount' => $opportunityCount,
                    'numberPerPage' => $numberPerPage,
                    'page' => $page,
                    'term' => '',
                ])->render(),
            ]);
        }

        return response()->json(['status' => 'error']);
    }

    public function paginateFavoriteOpportunities(Request $request)
    {
        $validatedData = $request->validate([
            'page' => 'required',
            'perPage' => 'required'
        ]);

        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        if ($user) {
            $numberPerPage = $request->perPage;
            $page = $request->page;
            $opportunities = $user->favoriteOpportunities()->with('company')->whereRaw('start_date >= CURDATE()')->skip(($page - 1) * $numberPerPage)->take($numberPerPage)->get();
            $opportunityCount = $user->favoriteOpportunities()->whereRaw('start_date >= CURDATE()')->count();

            return response()->json([
                'opportunities' => view('renders.profileOpportunitiesRender', [
                    'opportunities' => $opportunities,
                ])->render(),
                'pagination' => view('renders.paginationRender', [
                    'opportunityCount' => $opportunityCount,
                    'numberPerPage' => $numberPerPage,
                    'page' => $page,
                    'term' => '',
                ])->render(),
            ]);
        }

        return response()->json(['status' => 'error']);
    }

    public function paginateFinishedOpportunities(Request $request)
    {
        $validatedData = $request->validate([
            'page' => 'required',
            'perPage' => 'required'
        ]);

        $userInfo = User::auth();
        $user = $userInfo['user'];
        $guard = $userInfo['guard'];

        if ($user) {
            $numberPerPage = $request->perPage;
            $page = $request->page;
            $opportunities = Opportunity::whereRaw('start_date < CURDATE()')->where(function ($q) use ($user) {
                $q->whereHas('favoriteUsers', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                })->orWhereHas('goingUsers', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })->with('company');
            $opportunityCount = $opportunities->count();
            $opportunities = $opportunities->skip(($page - 1) * $numberPerPage)->take($numberPerPage)->get();

            return response()->json([
                'opportunities' => view('renders.profileOpportunitiesRender', [
                    'opportunities' => $opportunities,
                ])->render(),
                'pagination' => view('renders.paginationRender', [
                    'opportunityCount' => $opportunityCount,
                    'numberPerPage' => $numberPerPage,
                    'page' => $page,
                    'term' => '',
                ])->render(),
            ]);
        }

        return response()->json(['status' => 'error']);
    }
}
