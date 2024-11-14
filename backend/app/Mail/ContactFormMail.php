<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Form Mail',
            to: [env('MAIL_USERNAME')], // Địa chỉ email người nhận
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact', // Đảm bảo view này tồn tại
            with: ['details' => $this->contacts]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
