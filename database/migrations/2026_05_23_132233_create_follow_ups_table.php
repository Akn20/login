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
        Schema::create('follow_ups', function (Blueprint $table) {

    $table->id();

    /*
    |--------------------------------------------------------------------------
    | UUID FOREIGN KEYS
    |--------------------------------------------------------------------------
    */

    $table->uuid('consultation_id');

    $table->uuid('patient_id');

    $table->unsignedBigInteger('doctor_id');

    /*
    |--------------------------------------------------------------------------
    | FOLLOW-UP DETAILS
    |--------------------------------------------------------------------------
    */

    $table->date('follow_up_date');

    $table->enum('status', [
        'Pending',
        'Completed',
        'Missed'
    ])->default('Pending');

    $table->text('remarks')->nullable();

    $table->timestamps();

    /*
    |--------------------------------------------------------------------------
    | FOREIGN KEY CONSTRAINTS
    |--------------------------------------------------------------------------
    */

    $table->foreign('consultation_id')
          ->references('id')
          ->on('consultations')
          ->onDelete('cascade');

    $table->foreign('patient_id')
          ->references('id')
          ->on('patients')
          ->onDelete('cascade');

    $table->foreign('doctor_id')
          ->references('id')
          ->on('staff')
          ->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
