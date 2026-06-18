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
        Schema::create('bank_verifications', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Relationship
            $table->uuid('financial_reconciliation_id');

            // Bank Details
            $table->string('bank_name');

            $table->decimal('deposit_amount', 12, 2);

            $table->date('deposit_date');

            $table->string('reference_number')->nullable();

            // Verification
            $table->enum('verification_status', [
                'Pending',
                'Verified',
                'Mismatch'
            ])->default('Pending');

            // Verified By
            $table->string('verified_by')->nullable();

            // Remarks
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();

            // Foreign Key
            $table->foreign('financial_reconciliation_id')
                ->references('id')
                ->on('financial_reconciliations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_verifications');
    }
};