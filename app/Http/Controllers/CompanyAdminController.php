<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Opportunity;
use App\PendingOpportunityAttribute;
use App\Category;
use App\Disability;
use App\Region;
use App\User;
use App\Query;
use App\Municipality;
use App\PlaceOfRegistration;
use App\CompanyStatus;
use App\CompanyWorkingType;
use App\FAQ;
use App\OpportunityMedia;
use App\OpportunityType;
use App\OpportunitySubtype;
use App\QueryMessage;
use Auth;
use ImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Log;

use Spatie\MediaLibrary\Models\Media;

class CompanyAdminController extends BaseController
{

    /**
     * Display main admin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = auth()->guard('company')->user();
        $guard = 'company';
        $opportunities = $company->opportunities()->latest()->paginate(10); //Opportunity::with('opportunity_status')->get();
        $ongoingOpportunitiesCount = $company->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $company->opportunities()->whereRaw('end_date < CURDATE()')->count();
        return view('admin/index', [
            'admin' => true,
            'auth' => true,
            'opportunities' => $opportunities,
            'opportunities_count' => $opportunities->count(),
            'user' => $company,
            'guard' => $guard,
            'ongoingOpportunitiesCount' => $ongoingOpportunitiesCount,
            'finishedOpportunitiesCount' => $finishedOpportunitiesCount

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function opportunities()
    {
        $company = auth()->user();;
        $guard = 'company';
        $opportunities = $company->opportunities()->latest()->paginate(10); //Opportunity::with('opportunity_status')->get();
        $ongoingOpportunitiesCount = $company->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $company->opportunities()->whereRaw('end_date < CURDATE()')->count();
        return view('admin/index', [
            'admin' => true,
            'auth' => true,
            'opportunities' => $opportunities,
            'opportunities_count' => $opportunities->count(),
            'user' => $company,
            'guard' => $guard,
            'ongoingOpportunitiesCount' => $ongoingOpportunitiesCount,
            'finishedOpportunitiesCount' => $finishedOpportunitiesCount
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $newOpportunity = Opportunity::createNewInactive();

        return redirect()->route('create-new-opportunity', ['id' => $newOpportunity]);
    }

    public function createOpportunity($id)
    {
        $guard = 'company';
        $company = auth()->user();
        $opportunities = $company->opportunities()->latest()->paginate(10); //Opportunity::with('opportunity_status')->get();
        $ongoingOpportunitiesCount = $company->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $company->opportunities()->whereRaw('end_date < CURDATE()')->count();
        $categories = Category::all();
        $regions = Region::all();
        $disabilities = Disability::all();
        $types = OpportunityType::all();
        $subtypes = OpportunitySubtype::with('opportunity_type')->get();
        $municipalities = Municipality::with('region')->get();

        return view('admin/company/createOpportunity', [
            'user' => $company,
            'guard' => $guard,
            'admin' => true,
            'auth' => true,
            'categories' => $categories,
            'regions' => $regions,
            'municipalities' => $municipalities,
            'disabilities' => $disabilities,
            'types' => $types,
            'subtypes' => $subtypes,
            'opportunities' => $opportunities,
            'ongoingOpportunitiesCount' => $ongoingOpportunitiesCount,
            'finishedOpportunitiesCount' => $finishedOpportunitiesCount,
            'newOpportunityID' => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ka' => 'required',
            'name_en' => 'nullable',
            'description_ka' => 'required',
            'description_en' => 'nullable',
            'address_ka' => 'required',
            'address_en' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'schedule_date' => 'required|date|after_or_equal:today',
            'image' => 'mimes:jpeg,jpg,png',
            'email' => 'nullable|email'
        ]);
        $opportunity = new Opportunity();
        $opportunity->setTranslation('name', 'ka', $request->name_ka);
        $opportunity->setTranslation('name', 'en', $request->name_en);
        $opportunity->setTranslation('description', 'ka', $request->description_ka);
        $opportunity->setTranslation('description', 'en', $request->description_en);
        $opportunity->setTranslation('address', 'ka', $request->address_ka);
        $opportunity->setTranslation('address', 'en', $request->address_ka);
        $opportunity->latitude = $request->latitude;
        $opportunity->longitude = $request->longitude;
        $opportunity->phone = $request->phone;
        $opportunity->start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');
        $opportunity->end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
        $opportunity->schedule_date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->schedule_date)->format('Y-m-d');
        $opportunity->fb_page = $request->fb_page;
        $opportunity->linkedin_page = $request->linkedin_page;
        $opportunity->web_page = $request->web_page;
        
        $user = User::auth();
        if($user['guard'] == 'web'){
            if($user['user']->company != 1){
                return redirect()->back();
            }
            $opportunity->user_id = $user['user']->id;
        }else{
            $opportunity->company_id = $user['user']->id;
        }
        
        $opportunity->application_url = $request->application_url;

        if ($request->email) {
            $opportunity->email = $request->email;
        }

        $imagePath = null;

        $filePath = null;


        $opportunity->save();

        if (isset($request->file)) {
            foreach ($request->file as $file) {
                $originalname = $file->getClientOriginalName();
                $path = 'storage/' . $file->storeAs('temp_media', $originalname, 'public');
                $opportunity->addMedia($path)
                    ->toMediaCollection('file');
            }
        }

        if (isset($request->categories)) {
            foreach ($request->categories as $category) {
                $opportunity->categories()->attach($category);
            }
        }

        if (isset($request->regions)) {
            foreach ($request->regions as $region) {
                $opportunity->regions()->attach($region);
            }
        }

        if (isset($request->municipalities)) {
            foreach ($request->municipalities as $municipality) {
                $opportunity->municipalities()->attach($municipality);
            }
        }

        if (isset($request->disabilities)) {
            foreach ($request->disabilities as $disability) {
                $opportunity->disabilities()->attach($disability);
            }
        }

        if (isset($request->subtypes)) {
            foreach ($request->subtypes as $subtype) {
                $opportunity->opportunity_subtypes()->attach($subtype);
            }
        }

        return redirect()->route('opportunities');
    }

    public function storeNew(Request $request)
    {
        $validatedData = $request->validate([
            'name_ka' => 'required',
            'name_en' => 'nullable',
            'description_ka' => 'required',
            'description_en' => 'nullable',
            'address_ka' => 'requiredif:execution__form,=,application',
            'address_en' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'schedule_date' => 'required|date|after_or_equal:today',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'email' => 'nullable|email'
        ]);
        $opportunity = Opportunity::findOrFail($request->opportunity_id);
        $opportunity->is_draft = 1;
        $opportunity->inactive = 1;
        $opportunity->setTranslation('name', 'ka', $request->name_ka);
        $opportunity->setTranslation('name', 'en', $request->name_en);
        $opportunity->setTranslation('description', 'ka', $request->description_ka);
        $opportunity->setTranslation('description', 'en', $request->description_en);
        $opportunity->setTranslation('address', 'ka', $request->address_ka);
        $opportunity->setTranslation('address', 'en', $request->address_ka);
        $opportunity->latitude = $request->latitude;
        $opportunity->longitude = $request->longitude;
        $opportunity->min_age = $request->min_age;
        $opportunity->max_age = $request->max_age;
        $opportunity->phone = $request->phone;
        $opportunity->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $opportunity->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $opportunity->schedule_date = \Carbon\Carbon::parse($request->schedule_date)->format('Y-m-d');
        $opportunity->fb_page = $request->fb_page;
        $opportunity->linkedin_page = $request->linkedin_page;
        $opportunity->web_page = $request->web_page;
        $user = User::auth();
        if($user['guard'] == 'web'){
            if($user['user']->company != 1){
                return redirect()->back();
            }
            $opportunity->user_id = $user['user']->id;
        }else{
            $opportunity->company_id = $user['user']->id;
        }
        if ($request->registration_type == "simple") {
            $opportunity->application_url = null;
        } else {
            $opportunity->application_url = $request->application_url;
        }


        $opportunity->is_virtual = $request->execution__form == 'application';
        $opportunity->vitual_link = $request->zoom_link;
        $opportunity->live_translation_link = $request->live_url;
        $opportunity->query_id = Query::first()->id;
        if ($request->email) {
            $opportunity->email = $request->email;
        }

        $imagePath = null;

        $opportunity->save();

        if (isset($request->file)) {
            foreach ($request->file as $file) {
                $originalname = $file->getClientOriginalName();
                $path = 'storage/' . $file->storeAs('temp_media', $originalname, 'public');
                $opportunity->addMedia($path)
                    ->toMediaCollection('file');
            }
        }

        if (isset($request->categories)) {
            foreach ($request->categories as $category) {
                $opportunity->categories()->attach($category);
            }
        }

        if (isset($request->regions)) {
            foreach ($request->regions as $region) {
                $opportunity->regions()->attach($region);
            }
        }

        if (isset($request->municipalities)) {
            foreach ($request->municipalities as $municipality) {
                $opportunity->municipalities()->attach($municipality);
            }
        }

        if (isset($request->disabilities)) {
            foreach ($request->disabilities as $disability) {
                $opportunity->disabilities()->attach($disability);
            }
        }

        if (isset($request->subtypes)) {
            foreach ($request->subtypes as $subtype) {
                $opportunity->opportunity_subtypes()->attach($subtype);
            }
        }

        if (isset($request->faq_question)) {
            foreach ($request->faq_question as $key => $value) {
                FAQ::create([
                    'question' => $value,
                    'answer' => $request->faq_answer[$key],
                    'opportunity_id' => $opportunity->id
                ]);
            }
        }

        return redirect()->route('opportunities');
    }

    public function storeDraft(Request $request)
    {
        $opportunity = Opportunity::findOrFail($request->opportunity_id);

        $this->saveOpportunityDraft($request, $opportunity, false);
        return redirect()->route('opportunities');
    }

    public function showPreview(Request $request)
    {
        $opportunity = Opportunity::createNewInactive();
        if ($request->curr_opp_id) {
            $old_opp = Opportunity::findOrFail($request->curr_opp_id);
            $opportunity->image = $old_opp->image;
        }
        $this->saveOpportunityDraft($request, $opportunity, true);
        return redirect()->route('opportunity', ['id' => $opportunity->id]);
    }

    private function saveOpportunityDraft(Request $request, Opportunity $opportunity, bool $inactive)
    {
        // draft
        $opportunity->is_draft = true;
        $opportunity->inactive = $inactive;

        if (!$opportunity->inactive) {
            // Save Files only on draft
            if (isset($request->file)) {
                foreach ($request->file as $file) {
                    $originalname = $file->getClientOriginalName();
                    $path = 'storage/' . $file->storeAs('temp_media', $originalname, 'public');
                    $opportunity->addMedia($path)
                        ->toMediaCollection('file');
                }
            }
        }

        $opportunity->setTranslation('name', 'ka', $request->name_ka ?? "");
        $opportunity->setTranslation('name', 'en', $request->name_en ?? "");
        $opportunity->setTranslation('description', 'ka', $request->description_ka ?? "");
        $opportunity->setTranslation('description', 'en', $request->description_en ?? "");
        $opportunity->setTranslation('address', 'ka', $request->address_ka ?? "");
        $opportunity->setTranslation('address', 'en', $request->address_ka ?? "");
        $opportunity->latitude = $request->latitude ?? "";
        $opportunity->longitude = $request->longitude ?? "";
        $opportunity->min_age = $request->min_age ?? null;
        $opportunity->max_age = $request->max_age ?? null;
        $opportunity->phone = $request->phone ?? "";
        $opportunity->fb_page = $request->fb_page ?? "";
        $opportunity->linkedin_page = $request->linkedin_page ?? "";
        $opportunity->web_page = $request->web_page ?? "";
        $opportunity->application_url = $request->application_url ?? "";
        $opportunity->vitual_link = $request->zoom_link ?? "";
        $opportunity->live_translation_link = $request->live_url ?? "";

        $opportunity->is_virtual = $request->execution__form == 'application';

        if ($request->start_date) {
            $opportunity->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        }
        if ($request->end_date) {
            $opportunity->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        }
        if ($request->schedule_date) {
            $opportunity->schedule_date = \Carbon\Carbon::parse($request->schedule_date)->format('Y-m-d');
        }

        if ($request->email) {
            $opportunity->email = $request->email;
        }
        $opportunity->save();

        $opportunity->categories()->detach();
        if (isset($request->categories)) {
            foreach ($request->categories as $category) {
                $opportunity->categories()->attach($category);
            }
        }

        $opportunity->regions()->detach();
        if (isset($request->regions)) {
            foreach ($request->regions as $region) {
                $opportunity->regions()->attach($region);
            }
        }

        $opportunity->municipalities()->detach();
        if (isset($request->municipalities)) {
            foreach ($request->municipalities as $municipality) {
                $opportunity->municipalities()->attach($municipality);
            }
        }

        $opportunity->disabilities()->detach();
        if (isset($request->disabilities)) {
            foreach ($request->disabilities as $disability) {
                $opportunity->disabilities()->attach($disability);
            }
        }

        $opportunity->opportunity_subtypes()->detach();
        if (isset($request->subtypes)) {
            foreach ($request->subtypes as $subtype) {
                $opportunity->opportunity_subtypes()->attach($subtype);
            }
        }

        $opportunity->faqs()->delete();
        if (isset($request->faq_question)) {
            foreach ($request->faq_question as $key => $value) {
                FAQ::create([
                    'question' => $value,
                    'answer' => $request->faq_answer[$key],
                    'opportunity_id' => $opportunity->id
                ]);
            }
        }
    }

    public function uploadImage(Request $request)
    {
        $imageB64 = $request->img_base64;
        $opportunity = Opportunity::findOrFail($request->opp_id);
        if (preg_match('/^data:image\/(\w+);base64,/', $imageB64)) {
            $split = explode('/', explode(';', $imageB64)[0]);
            $type = $split[1];
            // create image name
            $imageName = $opportunity->id . '__' . \Carbon\Carbon::now() . '.' . $type;
            $imageName = str_replace(' ', '', $imageName);

            // decode base64 to image
            $croppedImage = substr($imageB64, strpos($imageB64, ',') + 1);
            $croppedImage = base64_decode($croppedImage);

            // save and optimize
            Storage::disk('public')->put($imageName, $croppedImage);
            $opportunity->image = $imageName;
            $opportunity->save();
            ImageOptimizer::optimize(public_path('/storage/' . $opportunity->image));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $opportunity = Opportunity::find($id);
        $company = auth()->guard('company')->user();
        return view('admin/company/editOpportunity', compact('opportunity', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Opportunity  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = auth()->user();
        $opportunity = $company->opportunities()->with(['opportunity_subtypes', 'municipalities'])->findOrFail($id);

        $goingUsers = $opportunity->goingUsers;
        $attendedUsers = null;
        $unattendedUsers = null;

        $isFinished = $opportunity->end_date->isPast();

        if ($isFinished) {
            $attendedUsers = $opportunity->attendedUsers();
            $unattendedUsers = $opportunity->unattendedUsers();
        }

        $user = auth()->user();
        $guard = 'company';
        $auth = true;
        $opportunities = $user->opportunities()->latest()->paginate(10); //Opportunity::with('opportunity_status')->get();
        $ongoingOpportunitiesCount = $user->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $user->opportunities()->whereRaw('end_date < CURDATE()')->count();

        $categories = Category::all();
        $regions = Region::all();
        $disabilities = Disability::all();
        $types = OpportunityType::all();
        $subtypes = OpportunitySubtype::with('opportunity_type')->get();
        $municipalities = Municipality::with('region')->get();
        $admin = true;


        $media = $opportunity->getMedia('file');
        $mediaUrls = [];
        foreach ($media as $item) {
            $mediaUrls[$item->file_name] = $item;
        }

        return view('admin/company/editOpportunity', compact(
            'disabilities',
            'opportunity',
            'isFinished',
            'goingUsers',
            'attendedUsers',
            'unattendedUsers',
            'user',
            'guard',
            'auth',
            'categories',
            'regions',
            'types',
            'subtypes',
            'municipalities',
            'opportunities',
            'ongoingOpportunitiesCount',
            'finishedOpportunitiesCount',
            'admin',
            'mediaUrls'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_ka' => 'required_if:is_draft,=,0',
            'name_en' => 'nullable',
            'description_ka' => 'required_if:is_draft,=,0',
            'description_en' => 'nullable',
            'address_ka' => 'requiredif:execution__form,=,application',
            'address_en' => 'nullable',
            'start_date' => 'required_if:is_draft,=,0|date',
            'end_date' => 'required_if:is_draft,=,0|date',
            'schedule_date' => 'required_if:is_draft,=,0|date',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'email' => 'nullable|email'
        ]);

        $opportunity = Opportunity::findOrFail($id);
        if ($opportunity->is_draft == 1 && $request->is_draft && $request->is_draft == 1) {
            $opportunity->is_draft = true;
        } else {
            $opportunity->is_draft = false;
        }
        $opportunity->inactive = false;
        $opportunity->setTranslation('name', 'ka', $request->name_ka);
        $opportunity->setTranslation('name', 'en', $request->name_en);
        $opportunity->setTranslation('description', 'ka', $request->description_ka);
        $opportunity->setTranslation('description', 'en', $request->description_en);
        $opportunity->setTranslation('address', 'ka', $request->address_ka);
        $opportunity->setTranslation('address', 'en', $request->address_ka);
        $opportunity->latitude = $request->latitude;
        $opportunity->longitude = $request->longitude;
        $opportunity->min_age = $request->min_age;
        $opportunity->max_age = $request->max_age;
        $opportunity->phone = $request->phone;
        $opportunity->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $opportunity->end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $opportunity->schedule_date = \Carbon\Carbon::parse($request->schedule_date)->format('Y-m-d');
        $opportunity->fb_page = $request->fb_page;
        $opportunity->linkedin_page = $request->linkedin_page;
        $opportunity->web_page = $request->web_page;
        if(is_null($opportunity->company_id)){
            $opportunity->user_id = auth()->user()->id;
        }else{
           $opportunity->company_id = auth()->guard('company')->user()->id; 
        }
        
        if ($request->registration_type == "simple") {
            $opportunity->application_url = null;
        } else {
            $opportunity->application_url = $request->application_url;
        }


        $opportunity->is_virtual = $request->execution__form == 'application';
        $opportunity->vitual_link = $request->zoom_link;
        $opportunity->live_translation_link = $request->live_url;
        $opportunity->query_id = Query::first()->id;
        if ($request->email) {
            $opportunity->email = $request->email;
        }
        $opportunity->update();

        if (isset($request->old_files)) {
            // Delete
            foreach ($opportunity->getMedia('file') as $media) {
                if (!in_array($media->id, $request->old_files)) {
                    Storage::delete($media->file_name);
                    $media->delete();
                }
            }
        }

        if (isset($request->file)) {
            // Add
            foreach ($request->file as $file) {
                $originalname = $file->getClientOriginalName();
                $path = 'storage/' . $file->storeAs('temp_media', $originalname, 'public');
                $opportunity->addMedia($path)
                    ->toMediaCollection('file');
            }
        }

        if (isset($request->categories)) {
            $opportunity->categories()->detach();
            foreach ($request->categories as $category) {
                $opportunity->categories()->attach($category);
            }
        }

        if (isset($request->regions)) {
            $opportunity->regions()->detach();
            foreach ($request->regions as $region) {
                $opportunity->regions()->attach($region);
            }
        }

        if (isset($request->municipalities)) {
            $opportunity->municipalities()->detach();
            foreach ($request->municipalities as $municipality) {
                $opportunity->municipalities()->attach($municipality);
            }
        }

        if (isset($request->disabilities)) {
            $opportunity->disabilities()->detach();
            foreach ($request->disabilities as $disability) {
                $opportunity->disabilities()->attach($disability);
            }
        }

        if (isset($request->subtypes)) {
            $opportunity->opportunity_subtypes()->detach();
            foreach ($request->subtypes as $subtype) {
                $opportunity->opportunity_subtypes()->attach($subtype);
            }
        }

        if (isset($request->faq_question)) {
            $opportunity->faqs()->delete();
            foreach ($request->faq_question as $key => $value) {
                FAQ::create([
                    'question' => $value,
                    'answer' => $request->faq_answer[$key],
                    'opportunity_id' => $opportunity->id
                ]);
            }
        }


        return redirect()->route('opportunities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Opportunity  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);

        $opportunity = Opportunity::find($request->id);
        $opportunity->forceDelete();
        return redirect()->route('opportunities');
    }

    public function companyProfile()
    {
        $company = auth()->user();
        $user = $company;
        $guard = 'company';
        $opportunities = $company->opportunities()->latest()->paginate(10); //Opportunity::with('opportunity_status')->get();
        $ongoingOpportunitiesCount = $company->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $company->opportunities()->whereRaw('end_date < CURDATE()')->count();
        $placeOfRegistration = $company->place_of_registration;
        $categories = Category::all();
        $regions = Region::all();
        $municipalities = Municipality::all();
        $statuses = CompanyStatus::all();
        $workingTypes = CompanyWorkingType::all();
        $companyRegions = $company->workingRegions;
        $companyMunicipalities = $company->workingMunicipalities;
        $companyCategories = $company->categories;
        $subscribedCategories = $company->subscribedCategories;
        $subscribedCompanies = $company->subscribedCompanies;
        $aMessages = $company->privateMessages();
        $companyStatus = null;
        // $companyStatus = $company->company_statuses->first();
        $companyTypes = $company->companyWorkingTypes;
        $admin = true;
        $auth = true;
        
        return view('admin.company.profile', compact(
            'company',
            'regions',
            'categories',
            'workingTypes',
            'companyRegions',
            'companyMunicipalities',
            'companyCategories',
            'subscribedCategories',
            'subscribedCompanies',
            'aMessages',
            'placeOfRegistration',
            'municipalities',
            'statuses',
            'companyStatus',
            'companyTypes',
            'admin',
            'auth',
            'user',
            'guard',
            'ongoingOpportunitiesCount',
            'finishedOpportunitiesCount'
        ));
    }

    public function updateCover(Request $request)
    {
        $validatedData = $request->validate([
            'cover_image' => 'required'
        ]);

        $top_position = $request->cover_top_position;
        $left_position = $request->cover_left_position;

        $company = auth()->guard('company')->user();

        $imagePath = null;

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $imagePath = $request->file('cover_image')->store('company_images', 'public');
            $imagePath = '/storage/' . $imagePath;

            $imageB64 = $request->cover_image_base64;
            if (preg_match('/^data:image\/(\w+);base64,/', $imageB64)) {
                $image = $request->file('cover_image');

                // create image name
                $imageName = $company->id . '__' . \Carbon\Carbon::now() . '__' . $image->getClientOriginalName();
                $imageName = str_replace(' ', '', $imageName);

                // decode base64 to image
                $croppedImage = substr($imageB64, strpos($imageB64, ',') + 1);
                $croppedImage = base64_decode($croppedImage);

                // save and optimize
                Storage::disk('public')->put($imageName, $croppedImage);
                //$opportunity->image = $imageName;
                //ImageOptimizer::optimize(public_path('/storage/' . $opportunity->image));
            }
        }

        Storage::delete($company->cover_image);

        $company->cover_image = '/storage/' . $imageName;
        $company->cover_top_position = 0;
        $company->cover_left_position = 0;
        $company->update();

        ImageOptimizer::optimize(public_path($company->cover_image));

        return redirect()->route('company-profile');
    }

    public function setCover(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required'
        ]);

        $company = auth()->guard('company')->user();

        $imageB64 = $request->code;
        if (preg_match('/^data:image\/(\w+);base64,/', $imageB64)) {
            $image = $request->file('cover_image');

            $split = explode('/', explode(';', $imageB64)[0]);
            $type = $split[1];

            // create image name
            $imageName = $company->id . '__' . \Carbon\Carbon::now() . '__.' . $type;
            $imageName = str_replace(' ', '', $imageName);

            // decode base64 to image
            $croppedImage = substr($imageB64, strpos($imageB64, ',') + 1);
            $croppedImage = base64_decode($croppedImage);
            $f = finfo_open();

            // save and optimize
            Storage::disk('public')->put($imageName, $croppedImage);
            //$opportunity->image = $imageName;
            //ImageOptimizer::optimize(public_path('/storage/' . $opportunity->image));
        }

        Storage::delete($company->cover_image);

        $company->cover_image = '/storage/' . $imageName;
        $company->cover_top_position = 0;
        $company->cover_left_position = 0;
        $company->update();

        ImageOptimizer::optimize(public_path($company->cover_image));

        return response()->json(['status' => 'success']);
    }

    public function setProfile(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required'
        ]);

        $company = auth()->guard('company')->user();

        $imageB64 = $request->code;
        if (preg_match('/^data:image\/(\w+);base64,/', $imageB64)) {
            $image = $request->file('cover_image');

            $split = explode('/', explode(';', $imageB64)[0]);
            $type = $split[1];

            // create image name
            $imageName = $company->id . '__' . \Carbon\Carbon::now() . '__.' . $type;
            $imageName = 'company_images/'  .str_replace(' ', '', $imageName);

            // decode base64 to image
            $croppedImage = substr($imageB64, strpos($imageB64, ',') + 1);
            $croppedImage = base64_decode($croppedImage);
            $f = finfo_open();

            // save and optimize
            Storage::disk('public')->put($imageName, $croppedImage);
            //$opportunity->image = $imageName;
            //ImageOptimizer::optimize(public_path('/storage/' . $opportunity->image));
        }

        Storage::delete($company->image);

        $company->image = '/storage/' . $imageName;
        $company->update();

        ImageOptimizer::optimize(public_path($company->image));

        return response()->json(['status' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function updateCompany(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'mimes:jpeg,jpg,png',
            'registration_id' => 'string|min:9|max:9',
            'email' => 'email',
            'password' => 'string|min:8|confirmed'
        ]);

        $company = auth()->guard('company')->user();

        if (isset($request->old_password)) {
            $hasher = app('hash');
            if ($hasher->check($request->old_password, $company->password)) {
                $company->password = bcrypt($request->password);

                $company->update();

                return redirect()->route('company-profile');
            }
            return back()->withErrors(['password' => 'errors.old_password.incorrect']);
        } elseif (isset($request->region)) {
            $regions = $request->regions;
            $company->workingRegions()->detach();
            if (isset($regions)) {
                foreach ($regions as $region) {
                    $company->workingRegions()->attach($region);
                }
            }
            return redirect()->route('company-profile');
        } elseif (isset($request->municipality)) {
            $municipalities = $request->municipalities;
            $company->workingMunicipalities()->detach();
            if (isset($municipalities)) {
                foreach ($municipalities as $municipality) {
                    $company->workingMunicipalities()->attach($municipality);
                }
            }
            return redirect()->route('company-profile');
        } elseif (isset($request->category)) {
            $categories = $request->categories;
            $company->categories()->detach();
            if (isset($categories)) {
                foreach ($categories as $category) {
                    $company->categories()->attach($category);
                }
            }
            return redirect()->route('company-profile');
        } elseif (isset($request->workingTypes)) {
            $workingTypes = $request->workingTypes;
            $company->companyWorkingTypes()->detach();
            if (isset($workingTypes)) {
                foreach ($workingTypes as $workingType) {
                    $company->companyWorkingTypes()->attach($workingType, ['description' => $request->working_type_description[$workingType] ?? '']);
                }
            }
        }

        if (isset($request->areal)) {
            $company->areal = $request->areal;
            $company->update();
        }
        if (isset($request->areal) && $company->areal === 'local' && (isset($request->workingRegions) || isset($request->workingMunicipalities))) {
            $regions = $request->workingRegions;
            $company->workingRegions()->detach();
            if (isset($regions)) {
                foreach ($regions as $region) {
                    $company->workingRegions()->attach($region);
                }
            }

            $municipalities = $request->workingMunicipalities;
            $company->workingMunicipalities()->detach();
            if (isset($municipalities)) {
                foreach ($municipalities as $municipality) {
                    $company->workingMunicipalities()->attach($municipality);
                }
            }
            return redirect()->route('company-profile');
        }
        if (isset($request->por_is_georgia)) {
            $por = $company->place_of_registration;
            if (!$por) {
                $por = new PlaceOfRegistration();
            }
            $por->is_georgia = $request->por_is_georgia;
            $por->region_id = $request->por_region == '0' ? null : $request->por_region;
            $por->municipality_id = $request->por_municipality == '0' ? null : $request->por_municipality;
            $por->address_text = $request->por_address_text;

            if ($request->same_address) {
                $company->address = $request->por_address_text;
            } else {
                $company->address = $request->info_address_text;
            }
            $por->company_id = $company->id;
            $por->save();
        }

        foreach ($request->all() as $key => $value) {
            if ((substr($key, 0, 1) === '_') || (substr($key, 0, 3) === 'por')) {
                continue;
            }

            if ($key == 'ogTag') {
                continue;
            }

            if ($key == 'workingTypes') {
                continue;
            }

            if ($key == 'status') {
                $company->company_statuses()->detach();
                $company->company_statuses()->attach($value, ['description' => $request->status_description]);
                continue;
            }

            if ($key == 'registration_date') {
                $company->registration_date = \Carbon\Carbon::parse($value)->format('Y-m-d');
                continue;
            }

            if ($key == 'delete_img') {
                Storage::delete($company->image);
                $company->image = '';
            }
            if ($key == 'address_text' || $key == 'prof_image_base64' || $key == 'legal_address' || $key == 'same_address' || $key  == 'info_address_text') {
                continue;
            }

            if ($key == 'status_description' || $key == 'working_type_description' || $key == 'workingMunicipalities' || $key == 'workingRegions' || $key == 'delete_img') {
                continue;
            }

            $exploded = explode("_", $key);
            if (count($exploded) == 2 && ($exploded[1] == 'ka' || $exploded[1] == 'en')) {
                $company->setTranslation($exploded[0], $exploded[1], $value);
            } elseif ($key == 'image') {
                $imagePath = null;

                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $imagePath = $request->file('image')->store('company_images', 'public');
                    $company->image = $imagePath;
                    ImageOptimizer::optimize(public_path('/storage/' . $company->image));

                    $imageB64 = $request->prof_image_base64;
                    if (preg_match('/^data:image\/(\w+);base64,/', $imageB64)) {
                        $image = $request->file('image');

                        // create image name
                        $imageName = $company->id . '__' . \Carbon\Carbon::now() . '__' . $image->getClientOriginalName();
                        $imageName = str_replace(' ', '', $imageName);
                        $imageName = 'company_images/' . $imageName;

                        // decode base64 to image
                        $croppedImage = substr($imageB64, strpos($imageB64, ',') + 1);
                        $croppedImage = base64_decode($croppedImage);

                        // save and optimize
                        Storage::disk('public')->put($imageName, $croppedImage);
                        $company->image = $imageName;
                        ImageOptimizer::optimize(public_path('/storage/' . $company->image));
                    }
                }
            } else {
                $company->{$key} = $value;
            }
        }
        $company->update();

        return redirect()->back();
    }

    public function attendedUser($oid, $uid)
    {
        $opportunity = Opportunity::find($oid);
        $user = User::find($uid);
        $company = auth()->guard('company')->user();

        $query = $opportunity->get_query;

        if (!$query) {
            $query = Query::first();
        }

        $questionsModels = $query->questions;
        $propertiesModels = $query->properties;

        $questions = [];
        $answers = [];

        foreach ($questionsModels as $question) {
            $questions[$question->id] = $question->text;
            $answer = $question->answers()->where('user_id', $uid)->where('opportunity_id', $oid)->first();
            if ($answer) {
                $answers[$question->id] = $answer->answer;
            }
        }

        $properties = [];

        foreach ($propertiesModels as $property) {
            $answer = $property->answers()->where('user_id', $uid)->where('opportunity_id', $oid)->first();
            if ($answer) {
                $properties[$property->text] = $answer->answer;
            }
        }

        $opportunityMessage = '';
        $companyMessage = '';

        $queryMessage = $opportunity->queryMessages()->where('user_id', $uid)->where('is_private', 0)->first();
        if ($queryMessage) {
            $opportunityMessage = $queryMessage->message;
        }

        $queryMessage = $company->queryMessages()->where('user_id', $uid)->where('company_opportunity_id', $oid)->where('is_private', 0)->first();
        if ($queryMessage) {
            $companyMessage = $queryMessage->message;
        }

        return view('admin.attendedUser', compact('company', 'user', 'opportunity', 'questions', 'answers', 'properties', 'opportunityMessage', 'companyMessage'));
    }

    public function unattendedUser($oid, $uid)
    {
        $opportunity = Opportunity::find($oid);
        $user = User::find($uid);
        $company = auth()->guard('company')->user();

        $query = $opportunity->get_query;

        if (!$query) {
            $query = Query::first();
        }

        $questionsModels = $query->unattended_questions;

        $questions = [];
        $answers = [];

        foreach ($questionsModels as $question) {
            $questions[$question->id] = $question->text;
            $answer = $question->answers()->where('user_id', $uid)->where('opportunity_id', $oid)->first();
            if ($answer) {
                $option = $answer->option;
                $optionText = $option->text;
                $answerText = '';
                if ($option->has_text_field) {
                    $answerText = $answer->text;
                }
                $answers[$question->id] = array($optionText, $answerText);
            }
        }


        $opportunityMessage = '';

        $queryMessage = $opportunity->queryUnattendedMessages()->where('user_id', $uid)->where('is_private', 0)->first();
        if ($queryMessage) {
            $opportunityMessage = $queryMessage->message;
        }

        return view('admin.unattendedUser', compact('company', 'user', 'opportunity', 'questions', 'answers', 'opportunityMessage'));
    }


    public function searchOpportunities(Request $request)
    {
        $term = $request->term;

        $company = auth()->guard('company')->user();

        $guard = 'company';
        $ongoingOpportunitiesCount = $company->opportunities()->whereRaw('end_date >= CURDATE()')->count();
        $finishedOpportunitiesCount = $company->opportunities()->whereRaw('end_date < CURDATE()')->count();

        if (!$term) {
            $opportunities = $company->opportunities()->latest()->paginate();
        } else {
            $opportunities = $company->opportunities()->where('name', 'like', '%' . $term . '%')->latest()->paginate();
        }

        return view('admin/index', [
            'admin' => true,
            'auth' => true,
            'opportunities' => $opportunities,
            'opportunities_count' => $opportunities->count(),
            'user' => $company,
            'guard' => $guard,
            'ongoingOpportunitiesCount' => $ongoingOpportunitiesCount,
            'finishedOpportunitiesCount' => $finishedOpportunitiesCount

        ]);
    }

    public function uploadMediaFiles(Request $request, $id)
    {
        $result_array = collect([]);

        foreach ($request->file as $file) {
            if ($file->isValid()) {
                $filePath = $file->store('/opportunity_files', 'public');
                $media = OpportunityMedia::create(['media_url' => $filePath, 'opportunity_id' => $id]);
                $result_array->push($media);
            }
        }
        return response()->json(['status' => 'success', 'result' => $result_array]);
    }

    public function media(Request $request, $id)
    {
        $opportunity = Opportunity::findOrFail($id);

        $medias = $opportunity->opportunity_medias;

        $result = collect();
        foreach ($medias as $media) {
            $result = $result->push(['name' =>  asset('/storage/' . $media->media_url), 'id' => $media->id]);
        }
        return response()->json($result);
    }

    public function deleteMedia(Request $request)
    {
        $company = auth()->guard('company')->user();

        if (! $company) {
            return;
        }

        $media = OpportunityMedia::findOrFail($request->id);
        if ($media->opportunities->company == $company) {
            $media->delete();
        }
    }

    public function changeStatus(Request $request)
    {
        $opportunity = Opportunity::findOrFail($request->opportunity_id);
        if ($request->users == null) {
            return redirect()->back();
        }

        foreach ($request->users as $userID) {
            $user = $opportunity->goingUsers()->where('user_id', $userID)->first();
            if ($user->pivot->approved == 0) {
                $user->pivot->approved = 1;
            } else {
                $user->pivot->approved = 0;
            }
            $user->pivot->update();
        }
        return redirect()->back();
    }

    public function deleteFeedback(Request $request)
    {
        if ($request->feedbacks == null) {
            return redirect()->back();
        }

        foreach ($request->feedbacks as $feedback_ids) {
            $arr = explode('-', $feedback_ids);
            foreach ($arr as $id) {
                if ($id == '') {
                    continue;
                }
                QueryMessage::findOrFail($id)->delete();
            }
        }
        return redirect()->back();
    }
}
