<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return response()->json(['msg' => 'User successfully created!']);
        } else {
            // return response()->json(['msg' => 'Error inserting user!']);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => false, 'msg' => 'Username and password incorrect']);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true, 'access_token' => $token, 'token_type' => 'Bearer', 'msg' => 'User successfully logged in!',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 200);
    }

    public function logout(Request $request)
    {
        try {
            // JWTAuth::logout();
            auth()->logout();

            // $this->guard()->logout();
            return response()->json(['success' => true, 'msg' => 'User Logged out']);

            // $this->guard()->logout();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
