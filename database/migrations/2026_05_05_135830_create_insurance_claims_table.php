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
       Schema::create('insurance_claims', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('claim_number')->unique();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('insurance_provider');
            $table->decimal('billed_amount', 10, 2);
            $table->date('claim_date');
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_claims');
    }
};
