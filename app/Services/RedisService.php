<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function createUserTemporary(array $userData, array $clientData)
    {
        $data = array_merge($userData, $clientData);
        $key = "temp_user:{$userData['phone']}";
        Redis::setex($key, 300, json_encode($data));
        return $key;
    }

    public function retrieveTemporaryUserData($phone)
    {
        $tempKey = "temp_user:{$phone}";
        $data = json_decode(Redis::get($tempKey), true);

        if (!$data) {
            throw new Exception("Données utilisateur non trouvées.");
        }

        Redis::del($tempKey);
        return $data;
    }


    public function deleteTemporaryUserData($phone)
    {
        $tempKey = "temp_user:{$phone}";
        Redis::del($tempKey);
    }

    public function extractUserData(array $data)
    {
        return array_intersect_key($data, array_flip(['firstName', 'lastName', 'email', 'phone', 'password', 'role_id']));
    }

    public function extractClientData(array $data)
    {
        return array_intersect_key($data, array_flip(['address', 'CIN']));
    }
}