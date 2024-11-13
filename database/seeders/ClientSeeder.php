<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'user_id' => User::where('email', 'client@example.com')->first()->id,
            'address' => 'Cite gadaye, Guediawaye',
            'CIN' => 'SN123456789',
        ]);
    }
}
