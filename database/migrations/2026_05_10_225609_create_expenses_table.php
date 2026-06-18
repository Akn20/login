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
    Schema::create('expenses', function (Blueprint $table) {

        $table->char('id', 36)->primary();

        // Relation fields
        $table->char('category_id', 36);
        $table->char('vendor_id', 36)->nullable();

        // Expense details
        $table->date('entry_date');

        $table->string('expense_type', 150);

        $table->date('invoice_date')->nullable();

        $table->string('invoice_number', 150)->nullable();

        $table->string('po_attachment')->nullable();

        // Amount section
        $table->decimal('grand_total', 12, 2)->default(0);

        // Payment details
        $table->enum('payment_status', [
            'Unpaid',
            'Partial',
            'Fully Paid'
        ])->default('Unpaid');

        $table->enum('payment_mode', [
            'Cash',
            'Online',
            'UPI',
            'Cheque',
            'DD'
        ])->nullable();

        $table->date('payment_date')->nullable();

        $table->decimal('paid_amount', 12, 2)->nullable();

        $table->string('transaction_id')->nullable();

        // Audit fields
        $table->timestamps();

        $table->softDeletes();

        // Foreign keys
        $table->foreign('category_id')
            ->references('id')
            ->on('expense_categories');

        $table->foreign('vendor_id')
            ->references('id')
            ->on('inventory_vendors');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('expenses', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropForeign(['vendor_id']);
    });

    Schema::dropIfExists('expenses');
}
};
