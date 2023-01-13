<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class SubscriptionController extends Controller
{
    public function unsubscribeToCompany(Request $request)
    {
        $companyId = $request->id;
        $user = auth()->guard('web')->user();
        if(!$user) {
            $user = auth()->guard('company')->user();
        }
        $user->unsubscribeToCompany($companyId);

        $company = Company::find($companyId);
        if ($company) {
            $subscriberCount = $company -> subscriberCount();
        } else {
            $subscriberCount = null;
        }

        return response()->json([
            'status' => 'success',
            'subscriberCount' => $subscriberCount
        ]);
    }

    public function subscribeToCompany(Request $request)
    {
        $companyId = $request->id;
        $user = auth()->guard('web')->user();
        if(!$user) {
            $user = auth()->guard('company')->user();
        }
        $user->subscribeToCompany($companyId);

        $company = Company::find($companyId);
        if ($company) {
            $subscriberCount = $company -> subscriberCount();
        } else {
            $subscriberCount = null;
        }

        return response()->json([
            'status' => 'success',
            'subscriberCount' => $subscriberCount
        ]);
    }

    public function unsubscribeToCategory(Request $request)
    {
        $categoryId = $request->id;
        $user = auth()->guard('web')->user();
        if(!$user) {
            $user = auth()->guard('company')->user();
        }
        $user->unsubscribeToCategory($categoryId);
       
        return response()->json(['status' => 'success']);
    }

    public function subscribeToCategory(Request $request)
    {
        $categoryId = $request->id;
        $user = auth()->guard('web')->user();
        if(!$user) {
            $user = auth()->guard('company')->user();
        }
        $user->subscribeToCategory($categoryId);

        return response()->json(['status' => 'success']);
    }
}
