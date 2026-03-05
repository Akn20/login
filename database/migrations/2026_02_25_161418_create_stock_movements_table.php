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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('medicine_id');
            $table->uuid('batch_id');
            $table->string('movement_type'); // PURCHASE / SALE / RETURN / EXPIRED
            $table->integer('quantity');
            $table->uuid('reference_id')->nullable();

            $table->timestamps();

            $table->foreign('medicine_id')
                  ->references('id')
                  ->on('medicines')
                  ->onDelete('cascade');

            $table->foreign('batch_id')
                  ->references('id')
                  ->on('medicine_batches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
