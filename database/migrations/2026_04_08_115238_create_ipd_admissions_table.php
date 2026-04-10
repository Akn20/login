<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ipd_admissions', function (Blueprint $table) {

            // Primary Key (UUID)
            $table->uuid('id')->primary();

            // Admission ID (Readable)
            $table->string('admission_id')->unique();

            // 🔗 Foreign Keys (UUID)
            $table->uuid('patient_id');
            $table->uuid('doctor_id')->nullable();
            $table->uuid('department_id')->nullable();

            $table->uuid('ward_id')->nullable();
            $table->uuid('room_id')->nullable();
            $table->uuid('bed_id')->nullable();

            // Admission Info
            $table->enum('admission_type', ['planned', 'emergency'])->default('planned');
            $table->enum('status', ['active', 'discharged', 'cancelled'])->default('active');

            $table->dateTime('admission_date');
            $table->dateTime('discharge_date')->nullable();

            // Payment
            $table->decimal('advance_amount', 10, 2)->default(0);

            // Insurance
            $table->boolean('insurance_flag')->default(false);
            $table->string('insurance_provider')->nullable();
            $table->string('policy_number')->nullable();

            // Notes
            $table->text('notes')->nullable();

            // Audit
            $table->uuid('created_by');

            $table->timestamps();

            // Indexes (performance)
            $table->index('patient_id');
            $table->index('doctor_id');
            $table->index('bed_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipd_admissions');
    }
