<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;


class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'phone'=> 'required|min:10',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' =>$request->phone,
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token, 'message' => 'Successfully sign up'], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $user = User::where('email', $request->email)->first();
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            #
            return response()->json(['token' => $token, 'user'=> $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   

    public function logout(){
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    
}
