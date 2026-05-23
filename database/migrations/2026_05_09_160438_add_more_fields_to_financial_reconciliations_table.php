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
        Schema::table('financial_reconciliations', function (Blueprint $table) {

            // Bank Verification Fields
            $table->string('bank_name')->nullable()->after('status');

            $table->string('deposit_reference')->nullable()->after('bank_name');

            $table->enum('verification_status', [
                'Pending',
                'Verified',
                'Mismatch'
            ])->default('Pending')->after('deposit_reference');

            // Digital Payment Tracking
            $table->string('payment_gateway')->nullable()->after('verification_status');

            $table->string('gateway_reference')->nullable()->after('payment_gateway');

            $table->enum('digital_payment_status', [
                'Pending',
                'Success',
                'Failed'
            ])->default('Pending')->after('gateway_reference');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_reconciliations', function (Blueprint $table) {

            $table->dropColumn([
                'bank_name',
                'deposit_reference',
                'verification_status',
                'payment_gateway',
                'gateway_reference',
                'digital_payment_status',
            ]);

        });
    }
};