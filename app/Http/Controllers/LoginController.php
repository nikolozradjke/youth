<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;

use Socialite;
use ImageOptimizer;

class LoginController extends BaseController
{
    public function loginPage()
    {
        return view('login', [
            'body_class' => 'white',
            'pagename' => 'login',
            'noLoginForm' => true
        ]);
    }

    public function logout()
    {
        if(auth()->guard('web')->check())
        {
            auth()->guard('web')->logout();
        }
        elseif(auth()->guard('company')->check()) {
            auth()->guard('company')->logout();
        }

        return redirect()->route('main');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $guard = 'web';

        $user = User::where('email', request()->email)
                    ->orWhere('phone', request()->email)
                    ->first();

        if(!$user) {
            $guard = 'company';
            $user = Company::where('email', request()->email)
                            ->orWhere('phone', request()->email)
                            ->first();
        }
        if(!$user) {
            return back() -> withErrors(['email' => 'errors.email.not_found'])->withInput($request->only(['email', 'password']));
        }

        $hasher = app('hash');
        if ($hasher->check($request->password, $user->password)) {

            $remember = false;
            if(isset($request->remember) && $request->remember) {
                $remember = true;
            }

            if(auth()->guard('web')->check())
            {
                auth()->guard('web')->logout();
            }
            elseif(auth()->guard('company')->check()) {
                auth()->guard('company')->logout();
            }

            auth()->guard($guard)->login($user, $remember);

            return redirect()->route('main');
        }

        return back() -> withErrors(['password' => 'errors.password.incorrect'])->withInput($request->only(['email', 'password']));
    }

    /**
     * Redirect the user to the social media authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        if($driver == 'facebook')
        {
            return Socialite::driver($driver)->fields([
                'first_name', 'last_name', 'email', 'gender', 'birthday'
            ])->scopes([
                'email'//, 'user_birthday', 'user_gender'
            ])->redirect();
        }
        return Socialite::driver($driver)->redirect();
    }

    private function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /**
     * Obtain the user information from social media driver.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {
        if($driver == 'facebook')
        {
            $user = Socialite::driver($driver)->fields([
                'first_name', 'last_name', 'email'//, 'gender', 'birthday'
            ])->user();
            
            $avatar_url = $user->getAvatar();

            $user = $user->user;

            $fbUser = User::where('email', $user['email'])->where(function($query) use($driver)
            {
                $query->whereNull('provider')
                ->orWhere('provider', '!=', $driver);
            })->first();

            $fbCompany = Company::where('email', $user['email'])->first();

            if($fbUser || $fbCompany)
            {
                return redirect()->route('login')->withErrors(['popup_email' => 'errors.email.exists']);
            }

            $u = User::where('provider_id', $user['id'])->where('provider', 'facebook')->first();

            if(!$u)
            {
                $path = null;
                if($avatar_url)
                {
                    $info = pathinfo($avatar_url);
                    $contents = file_get_contents($avatar_url);
                    $file = public_path('storage/user_images/') . 'facebook-' . $user['id'] . '.jpg';
                    file_put_contents($file, $contents);
                    $path = 'user_images/' . 'facebook-' . $user['id'] . '.jpg';
                }

                $password = $this->generateRandomString(20);

                $u = new User([
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'gender' => isset($user['gender']) ? $user['gender'] : null,
                    'birth_date' => isset($user['birthday']) ? \Carbon\Carbon::parse($user['birthday'])->format('Y-m-d') : null,
                    'is_complete' => false,
                    'provider_id' => $user['id'],
                    'provider' => $driver,
                    'password' => $password
                ]);

                if($path) 
                {
                    $u->image = $path;
                    ImageOptimizer::optimize(public_path('/storage/' . $u->image));
                }

                $u->save();
            }
        }
        else {
            $user = Socialite::driver($driver)->user();

            $avatar_url = $user->getAvatar();
            
            $user = $user->user;

            $googleUser = User::where('email', $user['email'])->where(function($query) use($driver)
            {
                $query->whereNull('provider')
                ->orWhere('provider', '!=', $driver);
            })->first();
            $googleCompany = Company::where('email', $user['email'])->first();

            if($googleUser || $googleCompany)
            {
                return redirect()->route('login')->withErrors(['popup_email' => 'errors.email.exists']);
            }

            $u = User::where('provider_id', $user['id'])->where('provider', 'google')->first();

            if(!$u)
            {
                $path = null;
                if($avatar_url)
                {
                    $info = pathinfo($avatar_url);
                    $contents = file_get_contents($avatar_url);
                    if(!isset($info['extension']))
                    {
                        $info['extension'] = 'jpg';
                    }
                    $file = public_path('storage/user_images/') . 'google-' . $user['id'] . '.' . $info['extension'];
                    file_put_contents($file, $contents);
                    $path = 'user_images/' . 'google-' . $user['id'] . '.' . $info['extension'];
                }

                $password = $this->generateRandomString(20);

                $u = new User([
                    'first_name' => $user['given_name'],
                    'last_name' => $user['family_name'],
                    'email' => $user['email'],
                    'is_complete' => false,
                    'provider_id' => $user['id'],
                    'provider' => $driver,
                    'password' => $password
                ]);

                if($path) 
                {
                    $u->image = $path;
                    ImageOptimizer::optimize(public_path('/storage/' . $u->image));
                }

                $u->save();
            }
        }

        auth()->guard('web')->login($u, true);

        return redirect()->route('main');
    }
}
