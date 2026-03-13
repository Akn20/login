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

<<<<<<< HEAD
    // $table->string('return_number')->unique();
    // $table->uuid('bill_id');
    //  $table->foreign('bill_id')->references('id')->on('sales_bills')->onDelete('cascade');
    $table->uuid('patient_id')->nullable();
=======
            $table->string('return_number')->unique();

            // Reference to sales bill
            $table->uuid('bill_id');
            $table->foreign('bill_id')
                  ->references('bill_id')
                  ->on('sales_bills')
                  ->cascadeOnDelete();

            // Patient reference
            $table->uuid('patient_id')->nullable();
>>>>>>> a33284c8c0bf333c4c0d5d9f6a198f794f01a6f7

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