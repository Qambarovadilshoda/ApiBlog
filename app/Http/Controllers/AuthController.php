<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('register')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);

    }
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'error'=> 'User not found or password is incorrect',
            ], 404);
        }
        $token = $user->createToken('login')->plainTextToken;
        return response()->json([
            'user'=> $user,
            'token'=> $token
        ]);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();//currentAccessToken
        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }
}
