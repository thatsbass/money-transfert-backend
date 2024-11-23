<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
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

    public function currentUserInfos()
    {
        $curUser = auth()->user();
        $client = $curUser->client;
        $account = Account::where('user_id',$curUser->id)->first();
        $accountData = $account ? $account->only(['id', 'balance', 'qrCode']) : null;
        $clientData = $client ? $client->only(['id', 'address', 'CIN']) : null;
        $user = ([
            'id' => $curUser->id,
            'firstName' => $curUser->firstName,
            'lastName' => $curUser->lastName,
            'phone' => $curUser->phone,
            'email' => $curUser->email,
            'photo' => $curUser->photo,
            'client' => $clientData,
            'account'=> $accountData,
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
        ]);
    }
}
