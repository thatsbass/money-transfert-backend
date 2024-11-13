<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['libelle' => 'CLIENT']);
        Role::create(['libelle' => 'DISTRIBUTOR']);
        Role::create(['libelle' => 'MERCHANT']);
    }
}
