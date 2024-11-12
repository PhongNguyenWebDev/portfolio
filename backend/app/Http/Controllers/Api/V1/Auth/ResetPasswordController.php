<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Kiểm tra xem token có hợp lệ không
        $user = User::where('email', $request->email)->first();

        // Kiểm tra nếu người dùng tồn tại và token hợp lệ
        if (!$user || !Password::tokenExists($user, $request->token)) {
            return response()->json(['message' => 'This password reset token is invalid.'], 400);
        }

        // Tiến hành đặt lại mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        // Kiểm tra trạng thái trả về 
        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => trans($status)], 200)
            : response()->json(['message' => trans($status)], 500);
    }
}
