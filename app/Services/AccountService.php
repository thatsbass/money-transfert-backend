<?php

namespace App\Services;

use App\Repositories\Interfaces\AccountRepositoryInterface;

class AccountService
{
    protected $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function createClientAccount($data)
    {
        return $this->accountRepository->create($data);
    }
}
