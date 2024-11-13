<?php

namespace App\Repositories;

use App\Models\Transfer;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;

class TransferRepository implements TransferRepositoryInterface
{
    public function create(array $data)
    {
        return Transfer::create($data);
    }

    public function getAll(){
      return Transfer::all();
    }

    public function get($id) {
      return Transfer::find($id);
    }


    public function update(array $data, $id)
    {
      return Transfer::where('id', $id)->update($data);
    }

    public function delete($id){
      return Transfer::destroy($id);
    }

}
