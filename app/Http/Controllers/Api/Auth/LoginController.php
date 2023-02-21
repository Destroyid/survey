<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\Admins;
use Illuminate\Foundation\Auth\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);

        $user = User::where('email', $creds['email'])->first();

        if(Hash::check($creds['password'], $user->password)) {

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'success',
                'data' => [
                    'token' => $tokenResult->accessToken,
                    'type' => 'Bearer',
                    'user' => $user
                ]
            ]);
        }
        if(! $token = auth()->guard('api')->attempt($creds))
        {
            return response()->json(['error' => true, 'message' => 'Incorrect login/password', $creds], 401);
        }
        return response()->json(['token' => $token]);
        
    }

    // public function test(Request $request)
    // {
    //     dd($request->user('api')->email);

    // }

    // public function register(Request $request){
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $admin = User::create([
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $token = Auth::login($admin);
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Admin created successfully',
    //         'admin' => $admin,
    //         'authorisation' => [
    //             'token' => $token,
    //             'type' => 'bearer',
    //         ]
    //     ]);
    // }
}
