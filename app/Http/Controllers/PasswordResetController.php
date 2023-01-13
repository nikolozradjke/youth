<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Company;
use App\MailTemplate;
use Illuminate\Support\Facades\Mail;
use DB;

class PasswordResetController extends BaseController
{
    public function showEmailForm()
    {
        return view('auth.passwords.email', [
            'noLoginForm' => true,
            'pagename' => 'passwordReset',
        ]);
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'noLoginForm' => true,
            'pagename' => 'passwordReset',
        ]);
    }

    public function requestPasswordReset(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        //You can add validation login here
        $user = User::where('email', $request->email)
            ->first();
        if (!$user) {
            $user = Company::where('email', $request->email)->first();
        }
        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'errors.email.not_found'])->withInput();
        }
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $this->generateRandomString(60),
            'created_at' => \Carbon\Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if ($this->sendResetEmail($request->email, $tokenData->token, $user)) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'web.email.sent']);
        } else {
            return redirect()->back()->withErrors(['error' => 'errors.error.try_again'])->withInput();
        }
    }

    private function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    private function sendResetEmail($email, $token, $user)
    {
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/' . app()->getLocale() . '/password-reset/reset-form/' . $token . '?email=' . urlencode($email));

        $mailTemplate = MailTemplate::where('mail_identifier', MailTemplate::$PASSWORD_RESET)->first();

        if ($mailTemplate) {
            $subject = $mailTemplate->subject;
            $mail = $mailTemplate->format([
                'LINK' => $link
            ]);
            $sender = $mailTemplate->sender;
        } else {
            $subject = "Password Reset";
            $msg = "როგორც ჩანს, პაროლის აღდგენა მოითხოვე,\n\n" .
                "ამისთვის მხოლოდ ამ ბმულზე გადასვლა და ინსტრუქციების მიყოლაა საჭირო:\n%s";
            $mail = sprintf($msg, $link);
            $sender = MailTemplate::$DEFAULT_MAIL;
        }

        try {
            //Here send the link with CURL with an external email API
            Mail::send('templates.email', ['text' => $mail], function ($message) use ($email, $subject, $sender) {
                $message->to($email)
                    ->from($sender)
                    ->subject($subject);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetPassword(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return redirect()->route('reset-email-form');

        $user = User::where('email', $tokenData->email)->first();
        $guard = 'web';
        // Redirect the user back if the email is invalid
        if (!$user) {
            $user = Company::where('email', $tokenData->email)->first();
            $guard = 'company';

            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'errors.email.not_found'])->withInput();
            }
        }
        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        auth()->guard($guard)->login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        return redirect()->route('main');
    }
}
