<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Remplacer foreignId par uuid() pour correspondre au type UUID de accounts
            $table->uuid('sender_id'); // Utilisation de uuid() pour sender_id
            $table->uuid('receiver_id'); // Utilisation de uuid() pour receiver_id

            // Définir les contraintes de clé étrangère
            $table->foreign('sender_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2);
            $table->enum('status',  ['PENDING', 'SUCCESS', 'FAILED', 'CANCELED']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
