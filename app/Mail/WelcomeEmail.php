<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pdfPath;

    public function __construct($user, $pdfPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('email.send-card')
                    ->subject('Bienvenue sur MoneyX')
                    ->attach($this->pdfPath, [
                        'as' => 'card.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}