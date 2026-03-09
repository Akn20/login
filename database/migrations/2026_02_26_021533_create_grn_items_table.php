<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grn_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('grn_id')->constrained('grns')->cascadeOnDelete();

            $table->string('medicine_name');
            $table->string('batch_no')->nullable();
            $table->string('expiry')->nullable(); // YYYY-MM (for UI month input)

            $table->integer('qty')->default(0);
            $table->integer('free_qty')->default(0);

            $table->decimal('purchase_rate', 12, 2)->default(0);
            $table->decimal('discount_percent', 6, 2)->default(0);
            $table->decimal('tax_percent', 6, 2)->default(0);

            $table->decimal('amount', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grn_items');
    }
};