<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubsriberController extends Controller
{
    public function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:subscribers'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $store = Subscriber::create([
            'email' => $request->email,
            'token' => $this->generateRandomString()
        ]);

        if($store){
            return response()->json([
                'status' => 1,
                'text' => trans('web.review_success')
            ]);
        }

        return response()->json([
            'status' => 1,
            'text' => trans('web.review_error')
        ]);
    }

    public function unsubscribe($token){
        $unsibscribeTarget = Subscriber::where('token', $token)->first();
        if($unsibscribeTarget){
            $unsibscribeTarget->delete();
            return 'თქვენ აღარ მოგივათ მეილები';
        }

        return 'ტოკენი არასწორია';
    }

    public function generateRandomString($length = 35) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
