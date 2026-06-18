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
        Schema::create('accountant_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('bill_id');
            $table->uuid('patient_id');

            $table->decimal('amount', 10, 2);
            $table->string('payment_mode'); // cash, upi, card, insurance
            $table->string('transaction_id')->nullable();

            $table->timestamp('payment_date')->useCurrent();

            $table->uuid('created_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountant_payments');
    }
};
