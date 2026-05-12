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


    Schema::table('sales_bills', function (Blueprint $table) {
        //$table->decimal('paid_amount', 10, 2)->default(0);
        //$table->decimal('balance_amount', 10, 2)->default(0);
        //$table->string('payment_status')->default('Unpaid');
       //$table->decimal('paid_amount', 10, 2)->default(0);
     //table->decimal('balance_amount', 10, 2)->default(0);
       //$table->string('payment_status')->default('Unpaid');
        //$table->string('invoice_status')->default('Draft');
        //$table->string('payment_mode')->nullable();
        //$table->text('remarks')->nullable();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_bills', function (Blueprint $table) {
            //
        });
    }
};
