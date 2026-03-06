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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();

            $table->integer('token_number');
            $table->date('token_date');

            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('doctor_id')->nullable();

            $table->enum('status', ['WAITING','IN_PROGRESS','SKIPPED','COMPLETED' ])->default('WAITING');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('department_id')->references('id')->on('department_master');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
