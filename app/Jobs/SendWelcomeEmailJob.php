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
    protected $qrCode;

    public function __construct(User $user, $qrCode)
    {
        $this->user = $user;
        $this->qrCode = $qrCode;
    }

    public function handle(PdfService $pdfService)
    {
        $pdfPath = $pdfService->generatePdf($this->qrCode);

        Mail::to($this->user->email)->send(new WelcomeEmail($this->user, $pdfPath));
    }
}