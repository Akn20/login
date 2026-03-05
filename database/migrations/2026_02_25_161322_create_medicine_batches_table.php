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
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('medicine_id');
            $table->string('batch_number', 100);
            $table->date('expiry_date');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('mrp', 10, 2);
            $table->integer('quantity');
            $table->integer('reorder_level');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('medicine_id')
                  ->references('id')
                  ->on('medicines')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_batches');
    }
};
