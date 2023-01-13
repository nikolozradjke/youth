<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Contact;

class ContactController extends BaseController
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

        $staticData = Contact::first();

        return view('contact', [
            'auth' => $user !== null,
            'user' => $user,
            'guard' => $guard,
            'has_filter' => true,
            'pagename' => 'contact',
            'categories' => $categories,
            'staticData' => $staticData
        ]);
    }
}
