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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('customer_id');
            $table->unsignedBigInteger('service_id')->nullable()->after('phone');
            $table->integer('duration')->nullable()->after('end_time');
            $table->boolean('is_member')->default(false)->after('duration');
            $table->string('payment_method')->nullable()->after('is_member');
            $table->decimal('amount', 10, 2)->default(0)->after('payment_method');
            $table->string('payment_status')->default('pending')->after('amount');
            $table->string('sleep')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['phone', 'service_id', 'duration', 'is_member', 'payment_method', 'amount', 'payment_status', 'sleep']);
        });
    }
};
