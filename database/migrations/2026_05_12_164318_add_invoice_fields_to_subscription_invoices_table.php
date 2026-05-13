<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('subscription_invoices', function (Blueprint $table) {

            $table->string('invoice_number')
                ->unique()
                ->after('subscription_id');

            $table->decimal('amount', 12, 2)
                ->default(0);

            $table->decimal('tax', 12, 2)
                ->default(0);

            $table->decimal('discount', 12, 2)
                ->default(0);

            $table->decimal('total_amount', 12, 2)
                ->default(0);

            $table->date('invoice_date')
                ->nullable();

            $table->date('due_date')
                ->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'overdue',
                'cancelled'
            ])->default('pending');

            $table->text('notes')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('subscription_invoices', function (Blueprint $table) {

            $table->dropColumn([
                'invoice_number',
                'amount',
                'tax',
                'discount',
                'total_amount',
                'invoice_date',
                'due_date',
                'status',
                'notes'
            ]);

        });
    }
};