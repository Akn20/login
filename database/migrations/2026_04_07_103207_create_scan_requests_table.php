<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
      Schema::create('scan_requests', function (Blueprint $table) {

    $table->uuid('id')->primary();

    // ✅ MATCH ALL TYPES
    $table->uuid('patient_id');               // UUID
    $table->unsignedBigInteger('scan_type_id'); // BIGINT
    $table->uuid('doctor_id');                // UUID ✅ FIXED

    $table->string('body_part');
    $table->text('reason')->nullable();
    $table->enum('priority', ['Normal', 'Urgent'])->default('Normal');
    $table->enum('status', [
        'Pending',
        'Scheduled',
        'Uploaded',
        'Under Review',
        'Approved',
        'Rejected'
    ])->default('Pending');

    $table->timestamps();

    // ✅ FOREIGN KEYS
    $table->foreign('patient_id')
        ->references('id')->on('patients')->onDelete('cascade');

    $table->foreign('scan_type_id')
        ->references('id')->on('scan_types')->onDelete('cascade');

    $table->foreign('doctor_id')
        ->references('id')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_requests');
    }
};
