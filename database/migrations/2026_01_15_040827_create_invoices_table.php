<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // | Field            | Type          | Notes            |
        // | ---------------- | ------------- | ---------------- |
        // | id               | bigint        | PK               |
        // | appointment_id   | bigint        | FK               |
        // | customer_id      | bigint        | FK               |
        // | total_amount     | decimal(10,2) |                  |
        // | wallet_deduction | decimal(10,2) |                  |
        // | payable_amount   | decimal(10,2) |                  |
        // | payment_mode     | enum          | `cash`, `online` |
        // | created_at       | timestamp     |                  |


        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->decimal('total_amount',10,2);
            $table->decimal('wallet_deduction',10,2);
            $table->decimal('payable_amount',10,2);
            $table->enum('payment_mode',['cash','online']);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
