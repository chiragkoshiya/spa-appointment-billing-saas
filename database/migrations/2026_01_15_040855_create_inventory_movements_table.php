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
        // | Field             | Type         | Notes |
        // | ----------------- | ------------ | ----- |
        // | id                | bigint       | PK    |
        // | inventory_item_id | bigint       | FK    |
        // | user_id           | bigint       | FK    |
        // | change_qty        | int          |       |
        // | reason            | varchar(255) |       |
        // | created_at        | timestamp    |       |


        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_item_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('change_qty');
            $table->string('reason');
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
        Schema::dropIfExists('inventory_movements');
    }
};
