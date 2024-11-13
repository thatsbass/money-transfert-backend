<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['error' => 'Phone number or password incorrect'], 401);
        }
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    public function logout()
    {
        $token = JWTAuth::getToken();

        if ($token) {
            Redis::setex('blacklist:' . $token, 3600, $token);
            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['error' => 'Token not provided'], 400);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user_id' => Auth::user()->id
        ]);
    }
}
