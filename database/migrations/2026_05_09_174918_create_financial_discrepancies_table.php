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
        Schema::create('financial_discrepancies', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // RELATIONSHIP
            $table->uuid('financial_reconciliation_id');

            // ISSUE DETAILS
            $table->string('issue_type');

            $table->decimal('expected_amount', 12, 2);

            $table->decimal('actual_amount', 12, 2);

            $table->decimal('difference_amount', 12, 2);

            // STATUS
            $table->enum('status', [
                'Open',
                'Under Review',
                'Resolved'
            ])->default('Open');

            // REVIEW
            $table->string('reviewed_by')
                ->nullable();

            // REMARKS
            $table->text('remarks')
                ->nullable();

            $table->softDeletes();

            $table->timestamps();

            // FOREIGN KEY
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
        Schema::dropIfExists('financial_discrepancies');
    }
};