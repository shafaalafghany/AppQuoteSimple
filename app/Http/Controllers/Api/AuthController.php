<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(80),
        ]);

        // return response()->json($user);
        return (new UserResource($user))->additional([
            'meta' => [
                'token' => $user->api_token,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $userLogin = auth()->user();
            return (new UserResource($userLogin))->additional([
                'meta' => [
                    'token' => $userLogin->api_token,
                ],
            ]);
        }

        return response()->json([
            'error' => 'Email or Password not match',
        ], 401);
    }
}
