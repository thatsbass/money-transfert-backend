<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    protected $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    public function getClientInfos($userId)
    {

        $client = $this->clientService->getClientById($userId);
        if ($client) {
            return response()->json(['client' => $client], 200);
        } else {
            return response()->json(['message' => 'Objet non trouvé'], 411);
        }
    }
}
