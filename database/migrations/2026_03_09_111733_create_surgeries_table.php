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
        Schema::create('surgeries', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->uuid('patient_id');

    $table->string('surgery_type');

    $table->date('surgery_date');

    $table->time('surgery_time');

    $table->string('ot_room');

    $table->unsignedBigInteger('surgeon_id');
    $table->unsignedBigInteger('assistant_doctor_id')->nullable();
    $table->unsignedBigInteger('anesthetist_id')->nullable();

    $table->enum('priority',['Normal','Emergency'])->default('Normal');

    $table->text('notes')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgeries');
    }
};
