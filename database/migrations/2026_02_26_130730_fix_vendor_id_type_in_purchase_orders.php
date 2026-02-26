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
        Schema::table('purchase_orders', function (Blueprint $table) {
            // Drop old column
            $table->dropColumn('vendor_id');
        });
        Schema::table('purchase_orders', function (Blueprint $table) {

            // Create new UUID column
            $table->uuid('vendor_id')->nullable();

            // Add foreign key
            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
        });
    }
};
