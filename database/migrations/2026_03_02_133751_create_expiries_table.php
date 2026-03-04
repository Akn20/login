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
        Schema::create('expiry_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('batch_id'); // medicine_batches.id
            $table->date('expiry_date')->nullable();
            $table->integer('quantity')->nullable();
            $table->enum('status', ['EXPIRED','EXPIRING', 'PENDING', 'APPROVED', 'COMPLETED'])->default('EXPIRING');
            $table->text('remarks')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('batch_id')->references('id')->on('medicine_batches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expiry_logs');
    }
};
