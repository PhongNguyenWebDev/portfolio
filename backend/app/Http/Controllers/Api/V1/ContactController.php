<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\CustomerResponseMail;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Gửi email cho chủ web
        $adminEmail = env('MAIL_USERNAME'); // Địa chỉ email của chủ web
        Mail::to($adminEmail)->send(new ContactFormMail($validatedData));

        // Gửi email cảm ơn cho khách hàng
        Mail::to($validatedData['email'])->send(new CustomerResponseMail($validatedData['name'], $validatedData['email']));


        return response()->json(['message' => 'Emails sent successfully'], 200);
    }
}
