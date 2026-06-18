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
        Schema::create('referrals', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('hospital_id')->nullable();

            $table->uuid('patient_id');

            $table->uuid('doctor_id');

            $table->uuid('referred_doctor_id');

            $table->uuid('referred_department_id')->nullable();

            $table->string('referral_type')->default('Internal');

            $table->string('priority')->default('Normal');

            $table->text('referral_reason');

            $table->text('clinical_notes')->nullable();

            $table->date('followup_date')->nullable();

            $table->string('status')->default('Pending');

            $table->uuid('created_by')->nullable();

            $table->uuid('updated_by')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};