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
            $table->uuid('sender_id');
            $table->uuid('receiver_id');
            $table->foreign('sender_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->enum('status', ['PENDING', 'SUCCESS', 'FAILED', 'CANCELED']);
            $table->text('reason_failed')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('success_at')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
