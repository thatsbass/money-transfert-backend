<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Interfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{

    public function create(array $data)
    {
        return Account::create($data);
    }

    public function getAll(){
      return Account::all();
    }

    public function get($id) {
      return Account::find($id);
    }


    public function update(array $data, $id)
    {
      return Account::where('id', $id)->update($data);
    }

    public function delete($id){
      return Account::destroy($id);
    }

}
