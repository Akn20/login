<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('vitals', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('hospital_id');
            $table->uuid('patient_id');
            $table->uuid('nurse_id'); // nurse (staff with role nurse)

            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('spo2')->nullable();
            $table->decimal('blood_sugar', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            $table->timestamp('recorded_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};