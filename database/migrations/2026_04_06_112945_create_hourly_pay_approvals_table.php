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
        Schema::table('hourly_pay_approvals', function (Blueprint $table) {

            // Staff reference
            $table->uuid('staff_id')->after('id');

            // Basic Details
            $table->string('work_type')->nullable()->after('staff_id');

            // Time Details
            $table->string('payroll_month')->after('work_type');
            $table->date('attendance_date')->after('payroll_month');
            $table->decimal('approved_hours', 5, 2)->after('attendance_date');

            // Context Details
            $table->string('shift_code')->nullable()->after('approved_hours');
            $table->string('day_type')->default('Working')->after('shift_code');
            $table->string('source_type')->default('Biometric')->after('day_type');

            // Approval Details
            $table->string('approval_status')->default('Pending')->after('source_type');
            $table->uuid('approved_by')->nullable()->after('approval_status');
            $table->date('approved_date')->nullable()->after('approved_by');

            // Payroll Lock
            $table->boolean('locked_for_payroll')->default(0)->after('approved_date');

            // Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hourly_pay_approvals', function (Blueprint $table) {

            $table->dropColumn([
                'staff_id',
                'work_type',
                'payroll_month',
                'attendance_date',
                'approved_hours',
                'shift_code',
                'day_type',
                'source_type',
                'approval_status',
                'approved_by',
                'approved_date',
                'locked_for_payroll',
                'deleted_at'
            ]);
        });
    }
};