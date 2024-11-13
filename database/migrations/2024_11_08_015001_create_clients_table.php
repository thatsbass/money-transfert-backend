<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();  // Utilisation de UUID comme clé primaire
            $table->uuid('user_id');        // Utilisation de uuid pour la clé étrangère

            // Définir la contrainte de clé étrangère pour user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('address')->nullable();
            $table->string('CIN')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
