<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crée un utilisateur "Client"
        User::create([
            'firstName' => 'Bassirou',
            'lastName' => 'Diaw',
            'email' => 'client@example.com',
            'phone' => '+221786333750',
            'password' =>('0000'),
            'role_id' => Role::where('libelle', 'CLIENT')->first()->id,
        ]);

        // Crée un utilisateur "Distributor"
        User::create([
            'firstName' => 'Fama',
            'lastName' => 'Mbengue',
            'email' => 'distributor@example.com',
            'phone' => '+221771302004',
            'password' => ('0000'),
            'role_id' => Role::where('libelle', 'DISTRIBUTOR')->first()->id,
        ]);

        // Crée un utilisateur "Merchant"
        User::create([
            'firstName' => 'Bob',
            'lastName' => 'Marley',
            'email' => 'merchant@example.com',
            'phone' => '1122334455',
            'password' =>('0000'),
            'role_id' => Role::where('libelle', 'MERCHANT')->first()->id,
        ]);
    }
}
