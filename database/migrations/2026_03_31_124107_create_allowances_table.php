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
        Schema::create('allowances', function (Blueprint $table) {
    $table->uuid('id')->primary();

    // ================= BASIC =================
    $table->string('name')->unique();
    $table->string('display_name');
    $table->string('description')->nullable();

    // ================= CLASSIFICATION =================
    $table->enum('type', ['fixed', 'variable'])->default('fixed');
    $table->enum('nature',['fixed', 'variable'])->default('fixed');
    $table->date('start_date')->nullable();
  
    $table->enum('pay_frequency', ['monthly', 'quarterly', 'yearly', 'one_time'])->nullable();

    // ================= CALCULATION =================
    $table->enum('calculation_type', ['fixed', 'percentage', 'balancing'])->nullable();
    $table->enum('calculation_base', ['basic', 'gross'])->nullable();
    $table->decimal('calculation_value', 12, 2)->nullable();

    $table->enum('rounding_rule', ['nearest', 'up', 'down', 'none'])->nullable();
    $table->decimal('max_limit', 12, 2)->nullable();

    // ================= ATTENDANCE =================
    $table->boolean('lop_impact')->default(false);
    $table->boolean('prorata')->default(false);

    // ================= TAX & STATUTORY =================
    $table->boolean('taxable')->default(false);
    $table->string('tax_exemption_section')->nullable();

    $table->boolean('pf_applicable')->default(false);
    $table->boolean('esi_applicable')->default(false);
    $table->boolean('pt_applicable')->default(false);
    $table->boolean('tds_applicable')->default(false);

    // ================= PAYSLIP =================
    $table->boolean('show_in_payslip')->default(true);
    $table->integer('display_order')->nullable();

    // ================= POLICY =================
    $table->date('effective_from')->nullable();
    $table->date('effective_to')->nullable();

    // ================= CONTROL =================
    $table->boolean('status')->default(true);

    // ================= SYSTEM =================
    $table->timestamps();
    $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowances');
    }
};
