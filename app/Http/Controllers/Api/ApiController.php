<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    //Register API (POST, formdata)
    public function register(Request $request){
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "username" => "required|unique:users",
            "password" => "required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "password" => Hash::make($request->passowrd)
        ]);

        if($user){
            return response()->json([
                "status" => "200",
                "message" => "User created successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => "500",
                "message" => "Something went wrong"
            ], 500);
        }
    }

    //Login API (POST, formdata)
    public function login(Request $request){

        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth
        $user = User::where('email', $request->email)->first();

        if($user){
            // dd('here');
            // dd($request->password, $user->password);
            if($user->password == $request->password)
            {
                $token = JWTAuth::fromUser($user);
                // dd($token);
                return response()->json([
                    "status" => "true",
                    "message" => "User Logged in Successfully",
                    "token" => $token
                ]);
            }
            else{
                dd("password is invalid");
            }
        }
        // dd($request->email, $request->password, $token);

        if(!empty($token)){

            return response()->json([
                "status" => true,
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }
    }

    // Profile API (GET)
    public function profile(){
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile Data",
            "data" => $userData
        ]);
    }

    // Refresh Token API (GET)
    public function refreshToken(){
        $newToken  = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New Access Token Generated",
            "data" => $newToken
        ]);
    }

    // Logout API (GET)
    public function logout(){
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "Logout Success"
        ]);
    }
}
