<?php
namespace App\Services;

use App\Services\Interfaces\SmsServiceInterface;
use Twilio\Rest\Client;

class TwilioService implements SmsServiceInterface
{
    protected $client;
    protected $from;

    public function __construct($sid, $authToken, $from)
    {
        $this->client = new Client($sid, $authToken);
        $this->from = $from;
    }

    public function sendMessage(string $phoneNumber, string $message)
    {
        $this->client->messages->create($phoneNumber, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}