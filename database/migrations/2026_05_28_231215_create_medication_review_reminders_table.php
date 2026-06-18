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
        Schema::create('medication_review_reminders', function (Blueprint $table) {

    $table->char('id', 36)->primary();

    $table->char('consultation_medicine_id', 36);

    $table->char('patient_id', 36);

    $table->char('doctor_id', 36);

    $table->date('review_date');

    $table->enum('status', [
        'Pending',
        'Completed'
    ])->default('Pending');

    $table->text('remarks')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_review_reminders');
    }
};
