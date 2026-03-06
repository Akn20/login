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
        Schema::create('doctors', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('institution_id')->nullable();

            $table->string('doctor_code')->unique();

            $table->string('first_name');
            $table->string('last_name');

            $table->enum('gender', ['Male','Female','Other']);
            $table->date('date_of_birth')->nullable();

            $table->enum('specialization', [
                'GENERAL PHYSICIAN',
                'INTERNAL MEDICINE',
                'FAMILY MEDICINE',
                'CARDIOLOGY',
                'NEUROLOGY',
                'NEUROSURGERY',
                'ORTHOPEDICS',
                'SPINE SURGERY',
                'GYNECOLOGY',
                'OBSTETRICS',
                'PEDIATRICS',
                'DERMATOLOGY',
                'OPHTHALMOLOGY',
                'ENT',
                'ONCOLOGY',
                'GASTROENTEROLOGY',
                'ENDOCRINOLOGY',
                'NEPHROLOGY',
                'PULMONOLOGY',
                'UROLOGY',
                'PSYCHIATRY',
                'RADIOLOGY',
                'PATHOLOGY',
                'GENERAL SURGERY',
                'PLASTIC SURGERY',
                'EMERGENCY MEDICINE',
                'CRITICAL CARE MEDICINE'
            ])->default('GENERAL PHYSICIAN');

            $table->string('qualification');
            $table->string('license_number');

            $table->integer('experience_years')->default(0);

            $table->string('mobile',15);
            $table->string('email')->nullable();

            $table->decimal('consultation_fee',10,2)->nullable();
            $table->string('room_number')->nullable();

            $table->string('available_days')->nullable();
            $table->time('available_time_from')->nullable();
            $table->time('available_time_to')->nullable();

            $table->boolean('status')->default(true);

           

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
