<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status == Password::RESET_LINK_SENT
                ? response()->json(['message' => trans($status)], 200)
                : response()->json(['message' => trans($status)], 404); // Trả về 404 nếu email không tồn tại
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while sending the email.'], 500);
        }
    }
}
