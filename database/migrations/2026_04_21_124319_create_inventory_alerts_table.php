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
        Schema::create('inventory_alerts', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('item_id');
    $table->string('alert_type'); // LOW_STOCK / EXPIRY
    $table->text('message');
    $table->string('status')->default('Pending');
    $table->timestamps();

    $table->foreign('item_id')->references('id')->on('inventory_items')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_alerts');
    }
};
