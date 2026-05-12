<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();               // Deduction Name
            $table->string('display_name');                 // Payslip label
            $table->text('description')->nullable();

            $table->enum('nature', ['FIXED', 'VARIABLE'])->default('FIXED');
            $table->enum('category', ['RECURRING', 'ADHOC'])->default('RECURRING');

            $table->enum('lop_impact', ['YES', 'NO'])->default('YES');
            $table->enum('prorata_applicable', ['YES', 'NO'])->default('YES');

            $table->enum('tax_deductible', ['YES', 'NO'])->default('YES');
            $table->enum('pf_impact', ['YES', 'NO'])->default('NO');
            $table->enum('esi_impact', ['YES', 'NO'])->default('NO');
            $table->enum('pt_impact', ['YES', 'NO'])->default('NO');

            $table->string('rule_set_code')->nullable();    // link to Deduction Rule Set master later

            $table->enum('show_in_payslip', ['YES', 'NO'])->default('YES');
            $table->unsignedInteger('payslip_order')->nullable();

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
