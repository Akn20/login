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
            $table->string('name')->unique(); // internal unique name
            $table->string('display_name');
            // ================= CLASSIFICATION =================
            $table->enum('type', ['fixed', 'variable'])->default('fixed');
            $table->enum('nature', ['fixed', 'variable'])->default('fixed');
            $table->enum('pay_frequency', ['monthly', 'quarterly', 'yearly', 'one_time'])->default('monthly');
            $table->date('start_date')->nullable();

            // ================= CALCULATION =================
            $table->enum('calculation_type', ['fixed', 'percentage', 'balancing']);
            $table->enum('calculation_base', ['basic', 'gross'])->nullable();
            $table->decimal('calculation_value', 12, 2)->nullable();

            $table->enum('rounding_rule', ['nearest', 'up', 'down', 'none'])->default('nearest');
            $table->decimal('max_limit', 12, 2)->nullable();

            // ================= ATTENDANCE =================
            $table->boolean('lop_impact')->default(true);
            $table->boolean('prorata')->default(true);

            // ================= TAX & STATUTORY =================
            $table->boolean('taxable')->default(true);
            $table->string('tax_exemption_section')->nullable();

            $table->boolean('pf_applicable')->default(true);
            $table->boolean('esi_applicable')->default(true);
            $table->boolean('pt_applicable')->default(false);
            $table->boolean('tds_applicable')->default(false);

            // ================= PAYSLIP =================
            $table->boolean('show_in_payslip')->default(true);
            $table->integer('display_order')->nullable();

            // ================= POLICY =================
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();

            // ================= CONTROL =================
            $table->boolean('status')->default(true); // active/inactive

            // ================= SYSTEM =================
            $table->timestamps();
            $table->softDeletes(); // for deleted page

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_allowances');
    }
};
