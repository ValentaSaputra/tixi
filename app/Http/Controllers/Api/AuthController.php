<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse 
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken($user->name. 'Auth-Token')->plainTextToken;

        return response()->json([
            'meesage' => 'Login Successful',
            'token_type' => 'Bearer',
            'token' => $token,
        ], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user) {
            $token = $user->createToken($user->name. 'Auth-Token')->plainTextToken;

            return response()->json([
                'meesage' => 'Registration Successful',
                'token_type' => 'Bearer',
                'token' => $token,
            ], 201);
        } else {
            return response()->json([
                'meesage' => 'Something went wrong! while registeration.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = User::where('id',$request->user()->id)->first();
       if($user) 
       {
            $user->tokens()->delete();

            return response()->json([
                'meesage' => 'Logged out successfully',
            ], 200);
       } 
       else 
       {
            return response()->json([
                'meesage' => 'User Not Found',
            ], 404);
       }
    }

    public function profile(Request $request): JsonResponse
    {
        if($request->user()) {
            return response()->json([
                'meesage' => 'User Profile',
                'data' => $request->user(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthenticated / Not Authenticated',
            ], 401);
        }
    }
}
