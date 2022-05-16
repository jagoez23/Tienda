<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApiController extends Controller
{
    public function register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'admin_since' => null,
            'disabled_at' => null,
            'email_verified_at' => Carbon::now(),
        ])->assignRole('user');

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
             'user' => $user,
             'access_token' => $token,
             'token_type' => 'Bearer'
        ], 200);
    }
}
