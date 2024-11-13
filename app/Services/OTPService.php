<?php

namespace App\Services;

use App\Jobs\OTPJob;
use Exception;
use Illuminate\Support\Facades\Redis;

class OTPService
{
    public function generateOtp($phoneNumber)
    {
        $otpCode = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $otpKey = "otp:{$phoneNumber}";
        $attemptsKey = "otp_attempts:{$phoneNumber}";

        // Stocker l'OTP avec expiration
        Redis::setex($otpKey, 300, $otpCode); // 5 minutes
        Redis::del($attemptsKey); // Réinitialiser les tentatives

        // Dispatch job pour envoyer OTP (SMS, etc.)
        OTPJob::dispatch($phoneNumber, $otpCode);

        return $otpCode;
    }

    public function verifyOTP($phoneNumber, $otpInput)
    {
        $otpKey = "otp:{$phoneNumber}";
        $attemptsKey = "otp_attempts:{$phoneNumber}";

        // Vérifier le nombre de tentatives
        $attempts = (int)Redis::get($attemptsKey) ?? 0;
        if ($attempts >= 3) {
            return "Trop de tentatives. Veuillez réessayer plus tard.";
        }

        // Récupérer l'OTP stocké
        $storedOtp = Redis::get($otpKey);

        // Vérifier l'OTP
        if (!$storedOtp || $storedOtp !== $otpInput) {
            // Incrémenter les tentatives
            Redis::incr($attemptsKey);
            Redis::expire($attemptsKey, 300); // 5 minutes

            return "Code OTP invalide.";
        }

        // OTP correct, nettoyer les clés Redis
        Redis::del($otpKey);
        Redis::del($attemptsKey);

        return true;
    }
}