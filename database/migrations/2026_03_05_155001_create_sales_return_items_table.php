<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_return_items', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Sales Return reference
            $table->uuid('sales_return_id');
            $table->foreign('sales_return_id')
                  ->references('id')
                  ->on('sales_returns')
                  ->cascadeOnDelete();

            // Medicine reference
            $table->uuid('medicine_id');
            $table->foreign('medicine_id')
                  ->references('id')
                  ->on('medicines')
                  ->cascadeOnDelete();

            // Batch reference
            $table->uuid('batch_id');
            $table->foreign('batch_id')
                  ->references('id')
                  ->on('medicine_batches')
                  ->cascadeOnDelete();

            $table->integer('quantity');

            $table->decimal('refund_amount',10,2);

            $table->string('reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_return_items');
    }
};