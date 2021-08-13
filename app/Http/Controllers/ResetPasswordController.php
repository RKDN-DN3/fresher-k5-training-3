<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    protected $email = null;
    public function forgotPassword(Request $request){
        $this->email = $request->only('email') ;
        $status = Password::sendResetLink(
            $this->email
            /* $request->only('email') */
        );
        if($status ==Password::RESET_LINK_SENT){
            return[
                'status' =>__($status)
            ];
        }
        throw ValidationException::withMessages([
            'email'=>[trans($status)],
        ]);
    }


    public function reset(Request $request){

        /* $request->validate([
            'token' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]); */
        
        $status = Password::reset(
            $request->only( $this->email, 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

       }
    /*
    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);

        if ($passwordReset){
            $user->notify(new MailResetPasswordNotification($passwordReset->token));
        }
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
            ]);
    }
    public function reset(Request $request, $token){
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()){
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 422);
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update($request->only('password'));
        $passwordReset->delete();
        return response()->json([
            'success' => $updatePasswordUser,
        ]);
    }*/
}
