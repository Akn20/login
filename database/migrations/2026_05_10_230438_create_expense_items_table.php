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
        Schema::create('expense_items', function (Blueprint $table) {

            $table->char('id', 36)->primary();

            // Parent expense relation
            $table->char('expense_id', 36);

            // Expense item details
            $table->string('expense_heading', 150);

            $table->integer('unit')->default(1);

            $table->decimal('unit_price', 12, 2)->default(0);

            $table->decimal('sub_total', 12, 2)->default(0);

            $table->decimal('cgst', 12, 2)->default(0);

            $table->decimal('sgst', 12, 2)->default(0);

            $table->decimal('igst', 12, 2)->default(0);

            $table->decimal('total', 12, 2)->default(0);

            $table->string('attachment')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_items', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
        });

        Schema::dropIfExists('expense_items');
    }
};