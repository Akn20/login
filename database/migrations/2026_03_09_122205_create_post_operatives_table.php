<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_operatives', function (Blueprint $table) {

            $table->id();

            $table->uuid('surgery_id');

            $table->text('procedure_performed')->nullable();

            $table->string('duration')->nullable();

            $table->string('blood_loss')->nullable();

            $table->text('patient_condition')->nullable();

            $table->text('recovery_instructions')->nullable();

            $table->string('complication_type')->nullable();

            $table->text('complication_description')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_operatives');
    }
};