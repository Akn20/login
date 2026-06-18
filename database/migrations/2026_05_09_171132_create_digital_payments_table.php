<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations.
     */
    public function up(): void
    {
        Schema::create('digital_payments', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Relationship
            $table->uuid('financial_reconciliation_id');

            // Payment Details
            $table->string('payment_method');

            $table->string('payment_gateway');

            $table->decimal('payment_amount', 12, 2);

            $table->date('payment_date');

            // Transaction
            $table->string('transaction_reference')
                ->nullable();

            // Matching Status
            $table->enum('matching_status', [
                'Pending',
                'Matched',
                'Mismatch',
                'Failed'
            ])->default('Pending');

            // Settlement
            $table->enum('settlement_status', [
                'Pending',
                'Settled',
                'Failed'
            ])->default('Pending');

            // Remarks
            $table->text('remarks')->nullable();

            $table->softDeletes();

            $table->timestamps();

            // Foreign Key
            $table->foreign('financial_reconciliation_id')
                ->references('id')
                ->on('financial_reconciliations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_payments');
    }
};