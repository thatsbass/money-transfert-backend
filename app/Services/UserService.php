<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;
    protected $dicebearService;

    public function __construct(UserRepositoryInterface $userRepository, DiceBearService $diceGen)
    {
        $this->userRepository = $userRepository;
        $this->dicebearService = $diceGen;
    }

    public function registerClient(array $userData, array $clientData)
    {
        $userDataCompleted = ([
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            'password' => $userData['password'],
            'role_id' => $userData['role_id'],
            'photo' => $this->dicebearService->generateAvatar($userData['firstName']),
        ]);
        return $this->userRepository->registerClient($userDataCompleted, $clientData);
    }
}
