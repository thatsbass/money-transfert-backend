<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

  protected $clientRepository;
  public function __construct(ClientRepositoryInterface $clientRepository) {
    $this->clientRepository = $clientRepository;

  }
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function registerClient(array $userData, array $clientData)
    {
        return DB::transaction(function () use ($userData, $clientData) {

            $user = $this->createUser($userData);
            $clientData['user_id'] = $user->id;
            return $this->clientRepository->create($clientData);
        });
    }
}
