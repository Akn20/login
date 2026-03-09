<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient_id');
            $table->uuid('doctor_id');
            $table->uuid('department_id');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('appointment_status', ['Scheduled', 'Cancelled', 'Completed'])->default('Scheduled');
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->char('hospital_id', 36);
            $table->uuid('receptionist_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('department_master')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('receptionist_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
