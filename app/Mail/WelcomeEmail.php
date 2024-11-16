<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    protected $pdfContent;

    public function __construct($user, $pdfContent)
    {
        $this->user = $user;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->view('email.send-card')
                    ->subject('Bienvenue à notre service !')
                    ->attachData($this->pdfContent, 'card.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
