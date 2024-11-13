<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('balanceMax', 15, 2)->default(200000);
            $table->decimal('balanceMensual', 15, 2)->default(1000000);
            $table->enum('currency', ['XOF', 'USD']);
            $table->string('qrCode')->nullable();
            $table->enum('status', ['ACTIVE', 'BLOCKED']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
