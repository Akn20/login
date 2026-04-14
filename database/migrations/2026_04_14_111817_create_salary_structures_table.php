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
    Schema::create('salary_structures', function (Blueprint $table) {
        $table->id();

        // 🔹 Identification
        $table->string('salary_structure_code')->unique();
        $table->string('salary_structure_name');
        $table->enum('structure_category', ['monthly', 'hourly']);
        $table->enum('status', ['active', 'inactive'])->default('active');

        // 🔹 Earnings Setup
        $table->json('fixed_allowance_components'); // multi-select FK
        $table->boolean('variable_allowance_allowed')->default(false);
        $table->unsignedBigInteger('residual_component_id'); // FK

        // 🔹 Time-Based Pay
        $table->boolean('hourly_pay_eligible')->default(false);
        $table->boolean('overtime_eligible')->default(false);
        $table->json('allowed_work_types')->nullable(); // multi-select FK

        // 🔹 Deduction Setup
        $table->json('fixed_deduction_components')->nullable(); // multi-select FK
        $table->boolean('variable_deduction_allowed')->default(false);

        // 🔹 Statutory Setup
        $table->boolean('pf_applicable')->default(false);
        $table->boolean('esi_applicable')->default(false);
        $table->boolean('pt_applicable')->default(false);
        $table->boolean('tds_applicable')->default(false);

        // 🔹 Extra (recommended)
        $table->date('effective_from')->nullable();
        $table->date('effective_to')->nullable();

        // 🔹 Soft Delete
        $table->softDeletes();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_structures');
    }
};
