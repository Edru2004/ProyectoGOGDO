<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class Send2FACode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu código de verificación de seguridad',
        );
    }

   public function content(): Content
{
    return new Content(
        view: 'emails.2fa_code', // <--- Asegúrate que diga esto
        with: ['code' => $this->code],
    );
}
}