<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\StaticDataAboutUs;

class AboutUsController extends BaseController
{
    public function loadPage()
    {
        $categories = Category::withCount('opportunities')->get();

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

        $staticData = StaticDataAboutUs::first();

        return view('about', [
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'has_filter' => true,
            'pagename' => 'about',
            'categories' => $categories,
            'staticData' => $staticData
        ]);
    }
}
