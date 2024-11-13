<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function registerClient(array $userData, array $clientData);
}
