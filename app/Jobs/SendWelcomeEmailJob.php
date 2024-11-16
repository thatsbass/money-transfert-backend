<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\PdfService;
use App\Mail\WelcomeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $qrCodeBase64;

    public function __construct(User $user, $qrCodeBase64)
    {
        $this->user = $user;
        $this->qrCodeBase64 = $qrCodeBase64;
    }

    public function handle(PdfService $pdfService)
    {
        // Générer le PDF en base64
        $pdfBase64 = $pdfService->generatePdf($this->qrCodeBase64);

        // Décoder le PDF en mémoire
        $pdfContent = base64_decode($pdfBase64);

        // Envoyer l'email avec le PDF attaché
        Mail::to($this->user->email)->send(new WelcomeEmail($this->user, $pdfContent));
    }
}
