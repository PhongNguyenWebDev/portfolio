<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class AuthController  extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            $user = User::find(Auth::id());

            // Tạo token với thời gian hết hạn là 2 giờ
            $token = $user->createToken('authToken', [], now()->addHours(2))->plainTextToken;

            // Cập nhật last_used_at cho token
            $personalAccessToken = $user->tokens()->where('name', 'authToken')->first();
            if ($personalAccessToken) {
                $personalAccessToken->last_used_at = Carbon::now();
                $personalAccessToken->save();
            }

            // Tạo cookie với token
            $cookie = cookie('token', $token, 120, '/', null, true, false);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user->makeHidden('password')
            ], 200)->withCookie($cookie);
        } else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
    }
    public function register(LoginRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'access_token' => $user->createToken('API Token of ' . $user->name)->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    public function logout(Request $request)
    {

        if ($request->user()) {
            // Xóa tất cả các token của người dùng
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'You are logged out'], 200);
        } else {
            return response()->json(['message' => 'Not authenticated'], 401);
        }
    }
}
