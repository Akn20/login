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
        Schema::create('patient_medical_flags', function (Blueprint $table) {
                $table->id();

                $table->uuid('patient_id');

                $table->enum('type', ['allergy', 'chronic']);

                $table->string('title'); // Diabetes, Penicillin allergy
                $table->text('description')->nullable();

                $table->string('severity')->nullable(); // low, medium, high

                $table->timestamps();

                $table->foreign('patient_id')
                    ->references('id')
                    ->on('patients')
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medical_flags');
    }
};
