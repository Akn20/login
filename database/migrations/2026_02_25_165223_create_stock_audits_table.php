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
        Schema::create('stock_audits', function (Blueprint $table) {
    $table->id();
    $table->date('audit_date');
    $table->foreignId('item_id')->constrained()->onDelete('cascade');
    $table->integer('system_stock');
    $table->integer('physical_stock');
    $table->integer('difference');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_audits');
    }
};
