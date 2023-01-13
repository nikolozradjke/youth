<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Category;
use App\Region;
use App\Code;
use App\CompanyStatus;
use App\CompanyWorkingType;
use App\MailTemplate;
use App\UserDisability;
use App\NumberOfEmployees;
use App\OpportunityType;
use App\StaticDataUserRegistration;
use App\PlaceOfRegistration;
use App\PlaceOfResidence;
use App\UserEducation;
use App\UserOccupation;
use App\UserOcupationStudy;
use App\UserOcupationWork;
use ImageOptimizer;
use App\UserSphere;
use App\UserSector;

use Illuminate\Support\Facades\Mail;

class RegistrationController extends BaseController
{
    public function userRegistration()
    {
        $staticData = StaticDataUserRegistration::first();
        $regions = Region::with('municipalities')->get();
        $userDissabilities = UserDisability::all();
        $userEducations = UserEducation::all();

        // Occupations
        $userOcupationStudy = UserOcupationStudy::all();
        $userOcupationWork = UserOcupationWork::all();
        $userOccupations = UserOccupation::all();

        return view('user-registration', [
            'body_class' => 'white',
            'termsData' => $staticData,
            'pagename' => 'registration',
            'noLoginForm' => true,
            'regions' => $regions,
            'userDissabilities' => $userDissabilities,
            'userEducations' => $userEducations,
            'userOcupationStudy' => $userOcupationStudy,
            'userOcupationWork' => $userOcupationWork,
            'userOccupations' => $userOccupations,
        ]);
    }
    
    // ახალგაზრდა მუშაკი
    public function userWorkerRegistration()
    {
        $staticData = StaticDataUserRegistration::first();
        $regions = Region::with('municipalities')->get();
        $userDissabilities = UserDisability::all();
        $userEducations = UserEducation::all();

        // Occupations
        $userOcupationStudy = UserOcupationStudy::all();
        $userOcupationWork = UserOcupationWork::all();
        $userOccupations = UserOccupation::all();
        
        $spheres = UserSphere::all();
        $sectors = UserSector::all();

        return view('user-worker-registration', [
            'body_class' => 'white',
            'spheres' => $spheres,
            'sectors' => $sectors,
            'termsData' => $staticData,
            'pagename' => 'registration',
            'noLoginForm' => true,
            'regions' => $regions,
            'userDissabilities' => $userDissabilities,
            'userEducations' => $userEducations,
            'userOcupationStudy' => $userOcupationStudy,
            'userOcupationWork' => $userOcupationWork,
            'userOccupations' => $userOccupations,
        ]);
    }

    public function companyRegistration()
    {
        $staticData = StaticDataUserRegistration::first();
        $regions = Region::with('municipalities')->get();
        $categories = Category::all();
        $numberOfEmployees = NumberOfEmployees::all();
        $companyStatuses = CompanyStatus::all();
        $companyWorkignTypes = CompanyWorkingType::with('CompanyWorkingSubtype')->get();

        return view('org-registration', [
            'body_class' => 'white',
            'termsData' => $staticData,
            'regions' => $regions,
            'categories' => $categories,
            'numberOfEmployees' => $numberOfEmployees,
            'companyStatuses' => $companyStatuses,
            'pagename' => 'registration',
            'companyWorkignTypes' => $companyWorkignTypes,
            'noLoginForm' => true,
        ]);
    }

    public function registerUser(Request $request)
    {

        $validationArray = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'email' => 'required|unique:companies|unique:users|email',
            'phone' => 'nullable|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'private_number' => 'nullable|digits:11|unique:users',
            'gender' => 'nullable|string',
        ];

        $validatedData = $request->validate($validationArray);

        if (isset($request->birth_date)) {
            $request->birth_date = \Carbon\Carbon::parse($request->birth_date)->format('Y-m-d');
        }

        $user = new User($validatedData);

        $user->company = $request->company;
        $user->birth_date = $request->birth_date;

        
        $user = new User($validatedData);

        $user->is_complete = true;
        $imagePath = null;

        // Set Gender
        if (isset($request->gender)) {
            $user->gender = $request->gender;
        }

        // Occupations
        // $user->user_ocupation_study_id = $request->user_ocupation_study_id;
        // $user->user_ocupation_work_id = $request->user_ocupation_work_id;
        // $user->user_occupation_id = $request->user_occupation_id;
        // $user->ocupation_description = $request->ocupation_description;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            //$imagePath = '/storage/' . $imagePath;
            $user->image = $imagePath;

            ImageOptimizer::optimize(public_path('/storage/' . $user->image));
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // User Disabilities
        // if ($request->disability_descriptions) {
        //     foreach ($request->disability_descriptions as $id => $desc) {
        //         $disability = UserDisability::find($id);
        //         $user->userDisabilities()->attach($disability, ['description' => $desc]);
        //     }
        // }

        // User Education
        if ($request->user_education_id) {
            $education = UserEducation::find($request->user_education_id);
            $user->userEducations()->attach($education);
        }
        $user->currently_studying = $request->user_education_description;

        // Place of Residence
        // PlaceOfResidence::create([
        //     'is_georgia' => $request->is_georgia,
        //     'address_text' => $request->address_text,
        //     'user_id' => $user->id,
        //     'region_id' => $request->region,
        //     'municipality_id' => $request->municipality,
        // ]);

        auth()->guard('web')->login($user, true);

        return redirect()->route('main')->with('registration_success', 'რეგისტრაცია წარმატებით დასრულდა');;
    }
    
    public function registerYoungWorker(Request $request)
    {

        $validationArray = [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'email' => 'required|unique:companies|unique:users|email',
            'phone' => 'nullable|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'private_number' => 'nullable|digits:11|unique:users',
            'gender' => 'nullable|string',
        ];

        $validatedData = $request->validate($validationArray);

        if (isset($request->birth_date)) {
            $request->birth_date = \Carbon\Carbon::parse($request->birth_date)->format('Y-m-d');
        }

        $user = new User($validatedData);

        $user->company = $request->company;
        $user->birth_date = $request->birth_date;
        $user->edu_name = $request->edu_name;
        $user->edu_grade = $request->edu_grade;
        $user->edu_info = $request->edu_info;
        $user->study_status = $request->study_status;
        $user->sector_id = $request->sector_id;
        $user->sphere_id = $request->sphere_id;
        $user->other_sector = $request->other_sector;

        $user->is_complete = true;
        $imagePath = null;

        // Set Gender
        if (isset($request->gender)) {
            $user->gender = $request->gender;
        }

        // Occupations
        $user->user_ocupation_study_id = $request->user_ocupation_study_id;
        $user->user_ocupation_work_id = $request->user_ocupation_work_id;
        $user->user_occupation_id = $request->user_occupation_id;
        $user->ocupation_description = $request->ocupation_description;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            //$imagePath = '/storage/' . $imagePath;
            $user->image = $imagePath;

            ImageOptimizer::optimize(public_path('/storage/' . $user->image));
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // User Disabilities
        if ($request->disability_descriptions) {
            foreach ($request->disability_descriptions as $id => $desc) {
                $disability = UserDisability::find($id);
                $user->userDisabilities()->attach($disability, ['description' => $desc]);
            }
        }

        // User Education
        if ($request->user_education_id) {
            $education = UserEducation::find($request->user_education_id);
            $user->userEducations()->attach($education);
        }
        $user->currently_studying = $request->user_education_description;

        // Place of Residence
        PlaceOfResidence::create([
            'is_georgia' => $request->is_georgia,
            'address_text' => $request->address_text,
            'user_id' => $user->id,
            'region_id' => $request->region,
            'municipality_id' => $request->municipality,
        ]);

        auth()->guard('web')->login($user, true);

        return redirect()->route('main')->with('registration_success', 'რეგისტრაცია წარმატებით დასრულდა');;
    }

    public function registerCompany(Request $request)
    {
        // Company Working Types
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|unique:companies|email',
            'phone' => 'nullable',
            'registration_id' => 'required|digits:9|unique:companies',
            'password' => 'required|string|min:8|confirmed',
            'description1' => 'required',
            'fb_page' => 'nullable',
            'linkedin_page' => 'nullable',
            'web_page' => 'nullable',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'document' => 'nullable|mimes:pdf',
            'type' => 'required',
            'areal' => 'required',
            'registration_date' => 'nullable'
        ]);

        if (isset($validatedData['registration_date'])) {
            $validatedData['registration_date'] = \Carbon\Carbon::parse($validatedData['registration_date'])->format('Y-m-d');
        }

        $user = new Company($validatedData);

        $user->number_of_employees_id = NumberOfEmployees::first()->id;
        $user->address = $request->info_address;

        $imagePath = null;
        $documentPath = null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('company_images', 'public');
            //$imagePath = '/storage/' . $imagePath;
            $user->image = $imagePath;

            ImageOptimizer::optimize(public_path('/storage/' . $user->image));
        }

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $documentPath = $request->file('document')->store('company_documents', 'public');
            //$documentPath = '/storage/' . $documentPath;
        }

        $user->password = bcrypt($request->password);
        $user->document = $documentPath;
        $user->phone2 = $request->phone2;
        $user->save();

        /*foreach($request->regions as $regionId)
        {
            $user->regions()->attach($regionId);
        }

        foreach($request->categories as $categoryId)
        {
            $category = Category::find($categoryId);
            if($category->has_description) {
                $user->categories()->attach($categoryId, ['description' => $request->category_description]);   
            }
            else {
                $user->categories()->attach($categoryId);
            }
        }*/

        $place = new PlaceOfRegistration();
        $place->is_georgia = intval($request->is_georgia);

        // Place Of Registration
        if (intval($request->is_georgia)) {
            $place->region_id = $request->region;
            $place->municipality_id = $request->municipality;
        }
        $place->company_id = $user->id;
        $place->address_text = $request->address_text;
        $place->save();
        /* Is Same adress?*/
        if (intval($request->addresses_match)) {
            $user->address = $request->address_text;
        } else {
            $user->address = $request->info_address_text;
        }

        // Company Status
        $companyStatus = CompanyStatus::find($request->company_status_id);
        if ($companyStatus->can_be_filled) {
            $user->company_statuses()->attach($companyStatus, ['description' => $request->company_status_description]);
        } else {
            $user->company_statuses()->attach($companyStatus);
        }

        // Company working regions
        if ($request->area_regions) {
            foreach ($request->area_regions as $region_id) {
                $user->workingRegions()->attach($region_id);
            }
        }

        // Company working municipalities
        if ($request->area_municipalities) {
            foreach ($request->area_municipalities as $municipality_id) {
                $user->workingMunicipalities()->attach($municipality_id);
            }
        }

        // Company Working Types
        $workingTypes = CompanyWorkingType::all();
        if ($request->working_types) {
            foreach ($request->working_types as $type_id) {
                $type = $workingTypes->find($type_id);
                if ($type->can_be_filled) {
                    $user->companyWorkingTypes()->attach($type_id, ['description' => $request->working_type_description[$type_id]]);
                } else {
                    $user->companyWorkingTypes()->attach($type_id);
                }
            }
        }

        auth()->guard('company')->login($user, true);
        $user->update();
        return redirect()->route('main', ['company_registered' => true])->with('registration_success', 'რეგისტრაცია წარმატებით დასრულდა');;
    }

    public function sendCode(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
        ]);

        $email = $request->email;
        $code = rand(1000, 9999) . '';

        $codeModel = Code::where('email', $email)->first();

        if (!$codeModel) {
            $codeModel = new Code([
                'email' => $email,
                'code' => $code
            ]);

            $codeModel->save();
        } else {
            $codeModel->code = $code;
            $codeModel->update();
        }
        $mailTemplate = MailTemplate::where('mail_identifier', MailTemplate::$REGISTRATION_SEND_CODE)->first();
        
        if ($mailTemplate) {
            $subject = $mailTemplate->subject;
            $mail = $mailTemplate->format([
                'CODE' => $code
            ]);
            $sender = $mailTemplate->sender;
        } else {
            $subject = "Registration";
            $msg = "მადლობა ახალგაზრდობის პლათფორმაზე დარეგისტრირებისთვის\n" .
            "გთხოვთ შეიყვანოთ ეს კოდი რეგისტრაციის გვერდზე:\n\n%s\n\n" .
            "გთხოვთ, არ გაანდოთ ეს კოდი მე-3 პირს.\n\n" .
            "იმ შემთხვევაში, თუ ვერ ახერხებთ რეგისტრაციის დასრულებას. გთხოვთ გაიმეოროთ პროცესი ან მოგვმართოთ ამავე ელ-ფოსტაზე.";
            $mail = sprintf($msg, $code);
            $sender = MailTemplate::$DEFAULT_MAIL;
        }
        Mail::send('templates.email', ['text' => $mail], function ($message) use ($email, $subject, $sender) {
            $message->to($email)
                ->from($sender)
                ->subject($subject);
        });

        return response()->json(['status' => 'success']);
    }

    public function checkCode(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'code'  => 'required'
        ]);
        $codeModel = Code::where('email', $request->email)->first();
        if (!$codeModel || $codeModel->code !== $request->code) {
            return response()->json(['status' => 'fail']);
        }
        return response()->json(['status' => 'success']);
    }

    public function validateEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email);
        $company = Company::where('email', $request->email);

        if (auth()->guard('web')->check()) {
            $user = $user->where('id', '!=', auth()->guard('web')->user()->id);
        } elseif (auth()->guard('company')->check()) {
            $company = $company->where('id', '!=', auth()->guard('company')->user()->id);
        }

        if ($user->first() || $company->first()) {
            return response()->json(['status' => 'fail']);
        }

        return response()->json(['status' => 'success']);
    }

    public function validatePrivateNumber(Request $request)
    {
        $validatedData = $request->validate([
            'private_number' => 'required|digits:11'
        ]);

        $user = User::where('private_number', $request->private_number);

        if (auth()->guard('web')->check()) {
            $user = $user->where('id', '!=', auth()->guard('web')->user()->id);
        }

        if ($user->first()) {
            return response()->json(['status' => 'fail']);
        }

        return response()->json(['status' => 'success']);
    }

    public function validateRegistrationNumber(Request $request)
    {
        $validatedData = $request->validate([
            'registration_id' => 'required|digits:9'
        ]);

        $company = Company::where('registration_id', $request->registration_id);

        if (auth()->guard('company')->check()) {
            $company = $company->where('id', '!=', auth()->guard('company')->user()->id);
        }

        if ($company->first()) {
            return response()->json(['status' => 'fail']);
        }


        return response()->json(['status' => 'success']);
    }

    public function validatePhoneNumber(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required',
            'registration_type' => 'required'
        ]);

        $model = null;

        if ($request->registration_type == 'user') {
            $model = User::where('phone', $request->phone);
            if (auth()->guard('web')->check()) {
                $model = $model->where('id', '!=', auth()->guard('web')->user()->id);
            }
            if ($model->first()) {
                return response()->json(['status' => 'fail']);
            }
        } else {
            $model = Company::where('phone', $request->phone);
            if (auth()->guard('company')->check()) {
                $model = $model->where('id', '!=', auth()->guard('company')->user()->id);
            }
            if ($model->first()) {
                return response()->json(['status' => 'fail']);
            }
        }

        return response()->json(['status' => 'success']);
    }


    public function registerCompanyTMP(Request $request)
    {
        
        if ($request->description1 == null)
            $request->request->add(['description1' => " "]);
        if ($request->address_text == null)
            $request->request->add(['address_text' => " "]);

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|unique:companies|email',
            'phone' => 'nullable',
            'registration_id' => 'required|digits:9|unique:companies',
            'password' => 'required|string|min:8|confirmed',
            'description1' => 'nullable',
            'fb_page' => 'nullable',
            'linkedin_page' => 'nullable',
            'web_page' => 'nullable',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'document' => 'nullable|mimes:pdf',
            'type' => 'nullable',
            'areal' => 'nullable',
            'registration_date' => 'nullable'
        ]);


        if (isset($validatedData['registration_date'])) {
            $validatedData['registration_date'] = \Carbon\Carbon::parse($validatedData['registration_date'])->format('Y-m-d');
        }
        
        $user = new Company($validatedData);
        $user->number_of_employees_id = NumberOfEmployees::first()->id;

        $imagePath = null;
        $documentPath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('company_images', 'public');
            //$imagePath = '/storage/' . $imagePath;
            $user->image = $imagePath;

            ImageOptimizer::optimize(public_path('/storage/' . $user->image));
        }
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $documentPath = $request->file('document')->store('company_documents', 'public');
            //$documentPath = '/storage/' . $documentPath;
        }

        $user->password = bcrypt($request->password);
        $user->document = $documentPath;
        $user->phone2 = $request->phone2;
        $user->save();

        $place = new PlaceOfRegistration();
        $place->is_georgia = intval($request->is_georgia);

        // Place Of Registration
        if ($request->municipality !== null) {
            if (intval($request->is_georgia)) {
                $place->region_id = $request->region;
                $place->municipality_id = $request->municipality;
            }
            $place->company_id = $user->id;
            $place->address_text = $request->address_text;
            $place->save();
            /* Is Same adress?*/
            if (intval($request->addresses_match)) {
                $user->address = $request->address_text;
            } else {
                $user->address = $request->info_address;
            }
        }
        // Company Status
        $companyStatus = CompanyStatus::find($request->company_status_id);
        if ($companyStatus->can_be_filled) {
            $user->company_statuses()->attach($companyStatus, ['description' => $request->company_status_description]);
        } else {
            $user->company_statuses()->attach($companyStatus);
        }

        // Company working regions
        if ($request->area_regions) {
            foreach ($request->area_regions as $region_id) {
                $user->workingRegions()->attach($region_id);
            }
        }

        // Company working municipalities
        if ($request->area_municipalities) {
            foreach ($request->area_municipalities as $municipality_id) {
                $user->workingMunicipalities()->attach($municipality_id);
            }
        }

        // Company Working Types
        $workingTypes = CompanyWorkingType::all();
        if ($request->working_types) {
            foreach ($request->working_types as $type_id) {
                $type = $workingTypes->find($type_id);
                if ($type->can_be_filled) {
                    $user->companyWorkingTypes()->attach($type_id, ['description' => $request->working_type_description[$type_id]]);
                } else {
                    $user->companyWorkingTypes()->attach($type_id);
                }
            }
        }

        auth()->guard('company')->login($user, true);
        $user->update();
        return redirect()->route('main', ['company_registered' => true])->with('registration_success', 'რეგისტრაცია წარმატებით დასრულდა');
    }
}
