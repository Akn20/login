<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hourly_pay_approvals', function (Blueprint $table) {

            $table->uuid('staff_id')->after('id');

            $table->string('work_type_code')
                  ->after('staff_id');

            $table->string('payroll_month')
                  ->after('work_type_code');

            $table->date('attendance_date')
                  ->after('payroll_month');

            $table->decimal('approved_hours', 5, 2)
                  ->after('attendance_date');

            $table->string('shift_code')
                  ->nullable()
                  ->after('approved_hours');

            $table->enum('day_type',
                ['Working', 'Weekend', 'Holiday']
            )->default('Working')
             ->after('shift_code');

            $table->enum('source_type',
                ['Biometric', 'Manual']
            )->default('Biometric')
             ->after('day_type');

            $table->enum('approval_status',
                ['Pending', 'Approved', 'Rejected']
            )->default('Pending')
             ->after('source_type');

            $table->uuid('approved_by')
                  ->nullable()
                  ->after('approval_status');

            $table->date('approved_date')
                  ->nullable()
                  ->after('approved_by');

            $table->boolean('locked_for_payroll')
                  ->default(0)
                  ->after('approved_date');

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