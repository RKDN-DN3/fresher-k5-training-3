<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['excepet' => ['logout', 'logout']]);
    }
    /**
     * Registration
     */
    public function register(Request $request)
    {
        /* $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone'=> 'required',
        'password' => 'required',
        ]); */
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
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
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $user = User::where('email', $request->email)->first();
           /*  $userRole = $user->role()->first();

            if ($userRole) {
                $this->scope = $userRole->role;
            } */
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

}
