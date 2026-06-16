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
    Schema::create('doctor_order_executions', function (Blueprint $table) {

        $table->uuid('id')->primary();

        $table->enum('order_type', [
            'Lab',
            'Medication',
            'Radiology'
        ]);

        $table->string('order_reference_id');

        $table->string('patient_id');

        $table->enum('execution_status', [
            'Pending',
            'Executed',
            'Escalated'
        ])->default('Pending');

        $table->text('remarks')->nullable();

        $table->text('escalation_reason')->nullable();

        $table->string('executed_by')->nullable();

        $table->timestamp('executed_at')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
  public function down(): void
{
    Schema::dropIfExists('doctor_order_executions');
}
};
