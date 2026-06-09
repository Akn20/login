<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Patient & Bill Info
            |--------------------------------------------------------------------------
            */

            $table->uuid('patient_id');

            $table->uuid('bill_id')->nullable();

            $table->string('bill_type')->nullable();
            // opd, ipd, pharmacy, lab

            /*
            |--------------------------------------------------------------------------
            | Refund Details
            |--------------------------------------------------------------------------
            */

            $table->string('refund_no')->unique();

            $table->date('refund_date');

            $table->enum('refund_type', [
                'OPD',
                'IPD',
                'PHARMACY',
                'LAB',
                'ADVANCE',
                'INSURANCE',
                'CANCELLATION'
            ]);

            $table->decimal('refund_amount', 10, 2);

            $table->text('refund_reason');

            $table->text('remarks')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Payment Details
            |--------------------------------------------------------------------------
            */

            $table->enum('refund_mode', [
                'Cash',
                'UPI',
                'Card',
                'Bank Transfer',
                'Insurance Adjustment'
            ])->nullable();

            $table->string('transaction_no')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Pending',
                'Under Verification',
                'Approved',
                'Rejected',
                'Processed',
                'Cancelled'
            ])->default('Pending');

            $table->uuid('requested_by');

            $table->uuid('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Supporting Documents
            |--------------------------------------------------------------------------
            */

            $table->string('document')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Foreign Keys
            |--------------------------------------------------------------------------
            */

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->cascadeOnDelete();

            $table->foreign('requested_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};