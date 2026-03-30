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
        Schema::create('offline_prescriptions', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->string('prescription_number')->unique();

    $table->string('patient_name');

    $table->string('patient_phone')->nullable();

    $table->string('doctor_name')->nullable();

    $table->string('clinic_name')->nullable();

    $table->date('prescription_date');

    $table->string('uploaded_prescription')->nullable();

    $table->enum('status',['Pending','Verified','Dispensed'])->default('Pending');

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_prescriptions');
    }
};