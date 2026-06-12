<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_invoices', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('subscription_id');

            $table->string('invoice_number')->unique();

            $table->decimal('amount', 10, 2)->default(0);

            $table->decimal('tax', 10, 2)->default(0);

            $table->decimal('discount', 10, 2)->default(0);

            $table->decimal('total_amount', 10, 2)->default(0);

            $table->date('invoice_date');

            $table->date('due_date');

            $table->enum('status', [
                'pending',
                'paid',
                'overdue',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_invoices');
    }
};