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
        Schema::create('ipd_prescriptions', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('ipd_id', 36);
            $table->char('patient_id', 36);
            $table->char('doctor_id', 36);

            $table->date('prescription_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_prescriptions');
    }
};
