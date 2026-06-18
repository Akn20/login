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
        Schema::create('doctor_radiology_notes', function (Blueprint $table) {

            $table->id();

            $table->uuid('doctor_id');
            $table->uuid('patient_id');
            $table->unsignedBigInteger('radiology_report_id');

            $table->text('interpretation_notes');

            $table->timestamps();

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            $table->foreign('radiology_report_id')
                ->references('id')
                ->on('radiology_reports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_radiology_notes');
    }
};
