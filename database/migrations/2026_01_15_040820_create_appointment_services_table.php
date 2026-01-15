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

        // | Field          | Type          | Notes    |
        // | -------------- | ------------- | -------- |
        // | id             | bigint        | PK       |
        // | appointment_id | bigint        | FK       |
        // | service_id     | bigint        | FK       |
        // | price          | decimal(10,2) | snapshot |
        // | created_at     | timestamp     |          |


        Schema::create('appointment_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->index();
            $table->unsignedBigInteger('service_id')->index();
            $table->decimal('price',10,2);
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
        Schema::dropIfExists('appointment_services');
    }
};
