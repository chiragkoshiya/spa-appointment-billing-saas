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
        Schema::table('staff', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('name');
            $table->date('dob')->nullable()->after('phone');
            $table->string('pan_photo')->nullable()->after('dob');
            $table->string('aadhaar_photo')->nullable()->after('pan_photo');
            $table->string('city')->nullable()->after('address');
            $table->string('work_last_place')->nullable()->after('city');
            $table->date('joining_date')->nullable()->after('work_last_place');
            $table->date('leaving_date')->nullable()->after('joining_date');
            $table->decimal('salary', 10, 2)->nullable()->after('leaving_date');
            $table->boolean('has_terms_conditions')->default(false)->after('salary');
            $table->text('terms_conditions_details')->nullable()->after('has_terms_conditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn([
                'photo',
                'dob',
                'pan_photo',
                'aadhaar_photo',
                'city',
                'work_last_place',
                'joining_date',
                'leaving_date',
                'salary',
                'has_terms_conditions',
                'terms_conditions_details'
            ]);
        });
    }
};
