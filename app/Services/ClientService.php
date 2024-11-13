<?php

namespace App\Services;


use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getClientById($id) {
      $client = $this->clientRepository->infosClient($id);
      return $client;
    }
}
