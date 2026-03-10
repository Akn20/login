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
       Schema::create('sales_returns', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->string('return_number')->unique();

    $table->foreignId('bill_id')->constrained('sales_bills')->cascadeOnDelete();

    $table->uuid('patient_id')->nullable();

    $table->decimal('total_refund', 12, 2)->default(0);

    $table->enum('status', [
        'Draft',
        'Submitted',
        'Approved',
        'Rejected',
        'Completed'
    ])->default('Draft');

    $table->text('remarks')->nullable();

    $table->uuid('created_by');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_returns');
    }
};
