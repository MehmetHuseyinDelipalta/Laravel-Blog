<?php
// app/Http/Controllers/ApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Merhaba, bu bir API örneğidir.'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'Successfully logged out!'], 200);
    }
}
