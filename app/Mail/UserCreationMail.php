<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class UserCreationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $pdfPath;



    public function __construct($user, $pdfPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MoneyX card',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.user_creation',
        );
    }

    public function build()
    {
        return $this->attach($this->pdfPath, [
                'as' => 'Card.pdf',
                'mime' => 'application/pdf',
            ])
            ->with([
                'user' => $this->user,
            ]);
    }

}