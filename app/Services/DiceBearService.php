<?php

namespace App\Services;

use GuzzleHttp\Client;

class DiceBearService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function generateAvatar($seed)
    {
        // URL de l'API DiceBear
        $url = "https://api.dicebear.com/9.x/glass/svg?seed={$seed}";
        return $url;
    }
}
