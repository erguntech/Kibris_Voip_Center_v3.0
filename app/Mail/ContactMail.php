<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.emails.contact.01'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email_contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
