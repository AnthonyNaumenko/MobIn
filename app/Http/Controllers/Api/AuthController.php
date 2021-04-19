<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $fields = $request->validate([
            'nickname' => 'required|string|unique:users,nickname',
            'email' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'nickname' => $fields['nickname'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'nickname' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check nickname
        $user = User::where('nickname', $fields['nickname'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function user()
    {
        $user = auth()->user();
        $response = [
            'user' => $user
        ];
        return response($response, 200);
    }

    public function update(Request $request)
    {
        if (auth()->user()) {
            $user = auth()->user();
            $userUpdate = User::find($user['id']);

            $fields = $request->validate([
                'nickname' => 'required|string|unique:users,nickname',
                'email' => 'required|string',
                'phone' => 'required|string',
                'password' => 'required|string|confirmed',
            ]);
            if ($fields['nickname'])
                $userUpdate->nickname = $fields['nickname'];
            if ($fields['email'])
                $userUpdate->email = $fields['email'];
            if ($fields['phone'])
                $userUpdate->phone = $fields['phone'];
            if ($fields['password'])
                $userUpdate->password = $fields['password'];

            $userUpdated = DB::table('users')
                ->where('id', $user['id'])
                ->update([
                    'nickname' => $userUpdate->nickname,
                    'email' => $userUpdate->email,
                    'phone' => $userUpdate->phone,
                    'password' => $userUpdate->password,
                ]);
            if ($userUpdated) {
                return [
                    'message' => 'User updated'
                ];
            }
        }
    }
}
