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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->string('po_number')->unique();
            $table->uuid('vendor_id')->nullable();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('set null');

            $table->date('order_date');
            $table->date('expected_date')->nullable();

            $table->decimal('total_amount', 12, 2)->default(0);

            $table->enum('status', [
                'draft',
                'approved',
                'ordered',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
