<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Interfaces\SmsServiceInterface;
use Illuminate\Support\Facades\Log;

class OTPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $phone;
    protected string $otp;

    public function __construct(string $phone, string $otp)
    {
        $this->phone = $phone;
        $this->otp = $otp;
    }

    public function handle(SmsServiceInterface $smsService)
    {
        $message = "Votre code OTP est : {$this->otp}";
        Log::info('Envoi du message : ' . $message);

        try {
            $smsService->sendMessage($this->phone, $message);
            Log::info('OTP envoyé avec succès à ' . $this->phone);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'OTP : " . $e->getMessage());
            $this->fail($e);
        }
    }
}