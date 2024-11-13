<?php

namespace App\Services\Interfaces;

interface SmsServiceInterface
{
    public function sendMessage(string $phoneNumber, string $message);
}

