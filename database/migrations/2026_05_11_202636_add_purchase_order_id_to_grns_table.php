<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grns', function (Blueprint $table) {

            $table->foreignId('purchase_order_id')
                ->nullable()
                ->after('id')
                ->constrained('purchase_orders')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::table('grns', function (Blueprint $table) {

            $table->dropForeign(['purchase_order_id']);

            $table->dropColumn('purchase_order_id');

        });
    }
};