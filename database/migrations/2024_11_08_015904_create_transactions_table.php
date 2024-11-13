<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->uuid('distributor_id');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('distributor_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('transactionType', ['DEPOSIT', 'WITHDRAW']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
