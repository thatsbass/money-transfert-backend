<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function getAll(){
      return Client::all();
    }

    public function get($id) {
      return Client::find($id);
    }


    public function update(array $data, $id)
    {
      return Client::where('id', $id)->update($data);
    }

    public function delete($id){
      return Client::destroy($id);
    }

    public function infosClient($userId){
      $clientDetails = Client::with('user')->where('user_id', $userId)->firstOrFail();
      return $clientDetails;
    }

}
