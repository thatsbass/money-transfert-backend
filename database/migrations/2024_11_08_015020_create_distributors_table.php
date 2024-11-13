<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorsTable extends Migration
{
    public function up()
    {
        Schema::create('distributors', function (Blueprint $table) {
            $table->uuid('id')->primary();  // Utilisation de UUID comme clé primaire
            $table->uuid('user_id');
            // $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('companyName');
            $table->string('licenseNumber')->unique();
            $table->string('qrCode')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distributors');
    }
}
