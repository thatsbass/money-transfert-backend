<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Utilisation de UUID comme clé primaire
            $table->string('firstName');
            $table->string('lastName');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
