<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_bill_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sales_bill_id')
                  ->constrained('sales_bills')
                  ->cascadeOnDelete();

            $table->uuid('medicine_id');
$table->foreign('medicine_id')->references('id')->on('medicines')->cascadeOnDelete();

            $table->uuid('batch_id');
    $table->foreign('batch_id')
          ->references('id')
          ->on('medicine_batches')
          ->cascadeOnDelete();

            $table->integer('quantity');
            $table->decimal('unit_price',10,2);
            $table->decimal('total_price',10,2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_bill_items');
    }
};