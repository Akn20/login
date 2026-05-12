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
        Schema::create('inventory_usage_logs', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('item_id');
    $table->double('quantity_used');
    $table->uuid('used_by')->nullable();
    $table->timestamp('used_at')->useCurrent();

    $table->foreign('item_id')->references('id')->on('inventory_items')->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_usage_logs');
    }
};
