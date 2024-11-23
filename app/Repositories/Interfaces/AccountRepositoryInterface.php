<?php

namespace App\Repositories\Interfaces;

interface AccountRepositoryInterface
{
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function getAll();
    public function get($id);
    public function getWithUser($accountId);
}
