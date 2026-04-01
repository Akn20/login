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
        Schema::create('emergency_cases', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('patient_name')->nullable();

            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile')->nullable();

            $table->string('emergency_type');
            $table->timestamp('arrival_time')->useCurrent();

            $table->string('status')->default('pending');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_cases');
    }
};
