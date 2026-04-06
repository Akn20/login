<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hourly_pay_approvals', function (Blueprint $table) {

            // Employee (Staff FK)
            $table->uuid('staff_id')->after('id');

            // Work Type (OT / HRLY)
            $table->string('work_type_code')->after('staff_id');

            // Payroll Month (Apr-2026)
            $table->string('payroll_month')->after('work_type_code');

            // Date
            $table->date('attendance_date')->after('payroll_month');

            // Hours
            $table->decimal('approved_hours', 5, 2)
                  ->after('attendance_date');

            // Shift
            $table->string('shift_code')
                  ->nullable()
                  ->after('approved_hours');

            // Day Type
            $table->enum('day_type',
                ['Working', 'Weekend', 'Holiday']
            )->default('Working')
             ->after('shift_code');

            // Source Type
            $table->enum('source_type',
                ['Biometric', 'Manual']
            )->default('Biometric')
             ->after('day_type');

            // Approval Status
            $table->enum('approval_status',
                ['Pending', 'Approved', 'Rejected']
            )->default('Pending')
             ->after('source_type');

            // Approved By (Staff)
            $table->uuid('approved_by')
                  ->nullable()
                  ->after('approval_status');

            // Approved Date
            $table->date('approved_date')
                  ->nullable()
                  ->after('approved_by');

            // Payroll Lock
            $table->boolean('locked_for_payroll')
                  ->default(0)
                  ->after('approved_date');

            // Soft Delete
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('hourly_pay_approvals', function (Blueprint $table) {

            $table->dropColumn([
                'staff_id',
                'work_type_code',
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