<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuthenticateMail extends Mailable
{
    use Queueable, SerializesModels;

    private $twoFactorCode;

    /**
     * Create a new message instance.
     *
     * @param string $twoFactorCode
     */
    public function __construct(string $twoFactorCode)
    {
        $this->twoFactorCode = $twoFactorCode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Two Factor Authenticate Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.two_factor_authenticate',
            with: [
                'twoFactorCode' => $this->twoFactorCode,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [

        ];
    }
}