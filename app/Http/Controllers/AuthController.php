<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{

    public function getuser(){
        $user = User::find("ff836e8a-948b-4724-a8a5-3dfcd9ea4a1c");
        return response()->json($user);
    }

    public function login(Request $request)
    {
       
        if (!$token = Auth::attempt($request->only('phone', 'password'))) {
            return response()->json(['error' => 'Phone number or password incorrect'], 401);
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

    private function me()
    {
        $curUser = auth()->user();
        $client = $curUser->client;
        $clientData = $client ? $client->only(['id', 'address', 'CIN']) : null;
        $user = ([
            'id' => $curUser->id,
            'firstName' => $curUser->firstName,
            'lastName' => $curUser->lastName,
            'email' => $curUser->email,
            'phone' => $curUser->phone,
            'role_id' => $curUser->role_id,
            'photo' => $curUser->photo,
            'client' => $clientData,
        ]);
        return $user;
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
            'user' => $this->me()
        ]);
    }
}
