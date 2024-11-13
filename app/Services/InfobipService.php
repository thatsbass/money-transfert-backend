<?php

namespace App\Services;

use App\Services\Interfaces\SmsServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class InfobipService implements SmsServiceInterface
{
    protected $apiKey;
    protected $apiUrl;


    public function __construct(string $apiKey, string $apiUrl)
    {
        if (empty($apiKey) || empty($apiUrl)) {
            throw new InvalidArgumentException('API key and URL are required for InfobipService');
        }

        Log::info('apikey : ' . $apiKey);
        Log::info('apiurl : ' . $apiUrl);
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    public function sendMessage(string $phoneNumber, string $message)
    {
        $response = Http::withHeaders([
            'Authorization' => "App {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post("{$this->apiUrl}/sms/1/text/single", [
            'from' => 'MoneyX',
            'to' => $phoneNumber,
            'text' => $message,
        ]);

        return $response->successful();
    }
}
