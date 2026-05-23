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
        Schema::create('financial_reconciliations', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->date('reconciliation_date');

            $table->decimal('total_cash', 12, 2)->default(0);

            $table->decimal('total_digital', 12, 2)->default(0);

            $table->decimal('total_bank_deposit', 12, 2)->default(0);

            $table->decimal('difference_amount', 12, 2)->default(0);

            $table->enum('status', [
                'Pending',
                'Matched',
                'Mismatch',
                'Verified'
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_reconciliations');
    }
};