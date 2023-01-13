<?php

namespace App\Http\Controllers;

use App\OgTag;
use Illuminate\Support\Facades\Route;
use App\Category;
use App\CompanyStatus;
use App\CompanyWorkingType;
use Illuminate\Http\Request;

use App\StaticDataUserRegistration;
use App\Contact;
use App\Disability;
use App\OpportunityFilter;
use App\OpportunitySubtype;
use App\OpportunityType;
use App\Region;

class BaseController extends Controller
{

    public static $SHORT_DOMAIN = "yp.gov.ge";

    public function __construct()
    {
        $notShowfilterOnPages = [
            route("about"),
            route("contact")
        ];

        $termsData = StaticDataUserRegistration::first();
        $regions    = Region::withCount('opportunities')->get();

        // User
        $contact = Contact::first();
        $categories = Category::all();
        $disabilities = Disability::all();
        $oppTypes = OpportunityType::all();
        $oppSubTypes = OpportunitySubtype::all();
        $opportunityCount = OpportunityFilter::filterOpportunities([], 'schedule_date', 'desc', 0, null)->count();

        // Company
        $companyStatuses = CompanyStatus::all();
        $companyWorkingTypes = companyWorkingType::all();


        $fb_link = null;
        $twitter_link = null;
        $insta_link = null;
        if ($contact) {
            $fb_link = $contact->fb_link;
            $twitter_link = $contact->twitter_link;
            $insta_link = $contact->insta_link;
        }

        view()->share([
            'notShowfilterOnPages' => $notShowfilterOnPages,
            'termsData' => $termsData,
            'fb_link' => $fb_link,
            'twitter_link' => $twitter_link,
            'insta_link' => $insta_link,
            'disabilities' => $disabilities,
            'regions' => $regions,
            'categories' => $categories,
            'total_count' => $opportunityCount,
            'companyStatuses' => $companyStatuses,
            'companyWorkingTypes' => $companyWorkingTypes,
            'oppTypes' => $oppTypes,
            'oppSubTypes' => $oppSubTypes,
        ]);
    }
}
