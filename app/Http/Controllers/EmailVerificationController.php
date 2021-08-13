<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    //
    public function sendVerificationEmail(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return[
                'message' => 'Already Verified'
            ];
        }
        $request->user()->sendPasswordResetNotification();
        return['status'=>'verification-link-sent'];
    }

    public function verifi(EmailVerificationRequest $request){
        if($request->user()->hasVerifiedEmail()){
            return[
            'message' => 'Email already verified'
            ];
        }
        if($request->user()->markEmailAsVerified()){
            event(new Verified($request->user()));
        }
        return[
            'message'=>'Email has been verified'
        ];
    }
}
