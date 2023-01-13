<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Category;
use App\Region;
use App\Opportunity;
use App\Company;
use App\OpportunityFilter;
use App\StaticDataMainPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends BaseController
{
    public function testMail(){
        Mail::send('email.subscribe', ['text' => 'test mail'], function ($message) {
            $message->to('nikakemu@yahoo.com')
                ->from('support@youthplatform.gov.ge')
                ->subject('test');
        });

        return 'Done';
    }
    public function index()
    {
        $items = [];
        $models = User::latest()->get();
        foreach($models as $model){
            $item = User::find($model->id);
            $items[] = [
                'name' => $model->first_name . ' ' . $model->last_name,
                'email' => $item->email,
                'gender' => $item->gender,
                'ID' => $item->private_number,
                'phone' => $item->phone,
                'birth_date' => $item->birth_date
            ];
        }

        $postfields = ['items' => $items];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://smartcms.loremipsum.ge/api/generate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postfields, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        dd(json_decode($response)->path);
        $vol_opportunities = OpportunityFilter::filterOpportunities(['types' => [2]], 'schedule_date', 'desc', 0, 8);
        $edu_opportunities = OpportunityFilter::filterOpportunities(['types' => [1]], 'schedule_date', 'desc', 0, 8);
        $young_opportunities = OpportunityFilter::filterOpportunities(['types' => [4]], 'schedule_date', 'desc', 0, 8);
        $other_opportunities = OpportunityFilter::filterOpportunities(['types' => [3, 5]], 'schedule_date', 'desc', 0, 8);

        $categories = Category::withCount('opportunities')->get();
        $regions    = Region::withCount('opportunities')->get();

        $user = null;

        $guard = 'web';

        if (auth()->guard('web')->check()) {
            $user = auth()->guard('web')->user();
            $guard = 'web';
            $subscribedCompanies = $user->companies->pluck('id')->toArray();
        } elseif (auth()->guard('company')->check()) {
            $user = auth()->guard('company')->user();
            $guard = 'company';
            $subscribedCompanies = $user->subscribedCompanies->pluck('id')->toArray();
        }

        $subscribedOpportunities = null;
        $showMoreSubscribed = false;

        if ($user) {
            $subscribedCategories = $user->subscribedCategories->pluck('id')->toArray();

            $subscribedOpportunities = OpportunityFilter::getSubscribedOnly($subscribedCompanies, $subscribedCategories, 4);
            if ($subscribedOpportunities->count() > 3) {
                $showMoreSubscribed = true;
                $subscribedOpportunities = $subscribedOpportunities->take(3);
            }


        }

        $topOpportunities = OpportunityFilter::filterOpportunities([], 'order', 'desc', 0, 5);

        $opportunities = OpportunityFilter::filterOpportunities([], 'schedule_date', 'desc', 0, 9);

        $staticData = StaticDataMainPage::all()->sortBy('order');

        if ($user && $guard == 'web') {
            foreach ($topOpportunities as $opportunity) {
                if ($user -> isFavorite($opportunity -> id)) {
                    $opportunity -> favorite = true;
                } else {
                    $opportunity -> favorite = false;
                }
            }

            foreach ($subscribedOpportunities as $opportunity) {
                if ($user -> isFavorite($opportunity -> id)) {
                    $opportunity -> favorite = true;
                } else {
                    $opportunity -> favorite = false;
                }
            }

            foreach ($opportunities as $opportunity) {
                if ($user -> isFavorite($opportunity -> id)) {
                    $opportunity -> favorite = true;
                } else {
                    $opportunity -> favorite = false;
                }
            }
        }

        return view('index', [
            'vol_opportunities' => $vol_opportunities,
            'edu_opportunities' => $edu_opportunities,
            'young_opportunities' => $young_opportunities,
            'other_opportunities' => $other_opportunities,
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'has_filter' => true,
            'categories' => $categories,
            'regions' => $regions,
            'topOpportunities' => $topOpportunities,
            'subscribedOpportunities' => $subscribedOpportunities,
            'showMoreSubscribed' => $showMoreSubscribed,
            'opportunities' => $opportunities,
            'staticData' => $staticData,
            'pagename' => 'index'
        ]);
    }
}
