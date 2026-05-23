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
    Schema::create('pre_payroll_adjustments', function (Blueprint $table) {

        //  UUID PRIMARY KEY (FIXED)
        $table->uuid('id')->primary();

        //  Identification
        $table->string('pre_payroll_code')->unique();
        $table->uuid('payroll_run_id')->nullable();
        $table->string('payroll_month');

        $table->uuid('employee_id'); //  changed to uuid
        $table->uuid('salary_assignment_id'); // changed to uuid

        // Scope
        $table->enum('pay_type', ['Monthly', 'Hourly']);

        //  Attendance
        $table->integer('working_days');
        $table->integer('days_paid');
        $table->decimal('lop_days', 5, 2)->nullable();
        $table->decimal('ot_hours', 5, 2)->nullable();

        //  Fixed
        $table->decimal('fixed_earnings_total', 10, 2)->default(0);
        $table->decimal('fixed_deductions_total', 10, 2)->default(0);

        //  Statutory
        $table->decimal('pf_employee', 10, 2)->nullable();
        $table->decimal('esi_employee', 10, 2)->nullable();
        $table->decimal('professional_tax', 10, 2)->nullable();
        $table->decimal('tds_amount', 10, 2)->nullable();

        //  Variable
        $table->decimal('adhoc_earnings', 10, 2)->nullable();
        $table->text('earnings_remarks')->nullable();

        $table->decimal('adhoc_deductions', 10, 2)->nullable();
        $table->text('deduction_remarks')->nullable();

        //  Preview
        $table->decimal('gross_earnings', 10, 2)->default(0);
        $table->decimal('total_deductions', 10, 2)->default(0);
        $table->decimal('net_payable', 10, 2)->default(0);

        //  Control
        $table->enum('status', ['Draft', 'Submitted', 'Approved'])->default('Draft');
        $table->uuid('submitted_by')->nullable(); // changed
        $table->uuid('approved_by')->nullable();  //  changed
        $table->timestamp('approved_on')->nullable();

        //  Audit
        $table->uuid('created_by')->nullable(); // hanged

        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_payroll_adjustments');
    }
};
