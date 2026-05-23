<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_results', function (Blueprint $table) {

            // Primary Key (UUID)
            $table->uuid('id')->primary();

            // Identification
            $table->string('payroll_run_id', 50);
            $table->uuid('staff_id');

            // Period
            $table->string('payroll_month', 20);
            $table->string('financial_year', 20);
            $table->string('academic_year', 20)->nullable();

            // Salary Context
            $table->string('salary_assignment_id', 50);
            $table->string('salary_structure_code', 50);

            // Attendance
            $table->integer('working_days');
            $table->integer('paid_days');
            $table->integer('lop_days');
            $table->decimal('overtime_hours', 5, 2)->nullable();

            // Earnings
            $table->decimal('fixed_earnings_total', 10, 2);
            $table->decimal('variable_earnings_total', 10, 2)->nullable();
            $table->decimal('gross_earnings', 10, 2);

            // Deductions
            $table->decimal('fixed_deductions_total', 10, 2);
            $table->decimal('variable_deductions_total', 10, 2)->nullable();

            // Statutory
            $table->decimal('pf_employee', 10, 2)->nullable();
            $table->decimal('esi_employee', 10, 2)->nullable();
            $table->decimal('professional_tax', 10, 2)->nullable();

            // Tax
            $table->decimal('tds_amount', 10, 2)->nullable();

            // Totals
            $table->decimal('total_deductions', 10, 2);
            $table->decimal('net_payable', 10, 2);

            // Control
            $table->enum('status', ['Locked', 'Reversed']);
            $table->dateTime('locked_on');
            $table->uuid('locked_by');

            // Audit
            $table->dateTime('created_on');
            $table->text('remarks')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_results');
    }
};