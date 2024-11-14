<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $customerEmail;

    public function __construct($customerName, $customerEmail)
    {
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Customer Response Mail',
            to: $this->customerEmail, // Gửi tới email của khách hàng
            from: env('MAIL_USERNAME'), // Địa chỉ email của bạn (chủ web)
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.customer', // Đảm bảo view này tồn tại
            with: ['name' => $this->customerName] // Truyền tên khách hàng vào view
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
