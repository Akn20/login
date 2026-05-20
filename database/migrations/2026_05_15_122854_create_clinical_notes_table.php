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
        Schema::create('clinical_notes', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->uuid('patient_id');

    $table->uuid('doctor_id');

    $table->uuid('report_id');

    $table->text('clinical_observation')->nullable();

    $table->text('diagnosis')->nullable();

    $table->text('follow_up_advice')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_notes');
    }
};
