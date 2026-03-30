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
        Schema::create('nurse_notes', function (Blueprint $table) {
           $table->uuid('id')->primary();

            $table->uuid('institution_id')->nullable();

            $table->uuid('patient_id'); // matches patients.id (char36)

            $table->unsignedBigInteger('nurse_id'); // matches staff.id (bigint)

            $table->enum('shift', ['Morning', 'Evening', 'Night']);

            $table->text('patient_condition')->nullable();
            $table->text('intake_details')->nullable();
            $table->text('output_details')->nullable();
            $table->text('wound_care_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_notes');
    }
};
