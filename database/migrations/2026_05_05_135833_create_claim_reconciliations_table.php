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
            Schema::create('claim_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->uuid('claim_id');
            $table->decimal('difference_amount', 10, 2);
            $table->boolean('is_reconciled')->default(false);
            $table->timestamps();

            $table->foreign('claim_id')->references('id')->on('insurance_claims')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_reconciliations');
    }
};
