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
        Schema::create('grn_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('grn_id')
          ->constrained()
          ->onDelete('cascade');

    $table->foreignId('item_id')
          ->constrained('items')
          ->onDelete('cascade');

    $table->integer('ordered_quantity');
    $table->integer('received_quantity');

    $table->decimal('unit_price', 10, 2);
    $table->decimal('total', 12, 2);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grn_items');
    }
};
