<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ipd_bills', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->uuid('ipd_id');

            $table->string('bill_no')->unique();
            $table->date('bill_date');

            $table->enum('status', ['interim', 'final'])->default('interim');

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);

            // after deducting advance
            $table->decimal('payable_amount', 10, 2)->default(0);

            $table->timestamps();

            // Foreign keys (optional for now if tables exist)
            // $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            // $table->foreign('ipd_id')->references('id')->on('ipd_admissions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_bills');
    }
};
