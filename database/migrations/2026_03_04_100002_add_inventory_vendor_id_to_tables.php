<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add inventory_vendor_id to purchase_orders table
        if (Schema::hasTable('purchase_orders') && !Schema::hasColumn('purchase_orders', 'inventory_vendor_id')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->uuid('inventory_vendor_id')->nullable()->after('vendor_id');
                $table->foreign('inventory_vendor_id')->references('id')->on('inventory_vendors')->onDelete('cascade');
            });
        }

        // Add inventory_vendor_id to purchases table
        if (Schema::hasTable('purchases') && !Schema::hasColumn('purchases', 'inventory_vendor_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->uuid('inventory_vendor_id')->nullable()->after('vendor_id');
                $table->foreign('inventory_vendor_id')->references('id')->on('inventory_vendors')->onDelete('cascade');
            });
        }

        // Add inventory_vendor_id to payments table
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'inventory_vendor_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->uuid('inventory_vendor_id')->nullable()->after('vendor_id');
                $table->foreign('inventory_vendor_id')->references('id')->on('inventory_vendors')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys and columns
        if (Schema::hasTable('purchase_orders')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->dropForeignIdIfExists('purchase_orders_inventory_vendor_id_foreign');
                $table->dropColumn('inventory_vendor_id', 'inventory_vendor_id');
            });
        }

        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropForeignIdIfExists('purchases_inventory_vendor_id_foreign');
                $table->dropColumn('inventory_vendor_id', 'inventory_vendor_id');
            });
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropForeignIdIfExists('payments_inventory_vendor_id_foreign');
                $table->dropColumn('inventory_vendor_id', 'inventory_vendor_id');
            });
        }
    }
};
