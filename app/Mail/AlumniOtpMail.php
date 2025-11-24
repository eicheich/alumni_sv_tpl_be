<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlumniOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alumniName;
    public $otpCode;

    /**
     * Create a new message instance.
     */
    public function __construct($alumniName, $otpCode)
    {
        $this->alumniName = $alumniName;
        $this->otpCode = $otpCode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP Verifikasi Alumni TPL',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.alumni-otp',
            with: [
                'alumniName' => $this->alumniName,
                'otpCode' => $this->otpCode,
            ],
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
