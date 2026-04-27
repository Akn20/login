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
        Schema::create('inventory_items', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->string('category')->nullable(); // reagent / consumable
    $table->double('quantity');
    $table->string('unit')->nullable(); // ml, mg, etc
    $table->double('threshold')->default(0);
    $table->date('expiry_date')->nullable();
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
