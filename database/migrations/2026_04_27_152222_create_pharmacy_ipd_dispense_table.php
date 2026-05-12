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
    Schema::create('pharmacy_ipd_dispense', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('prescription_id'); // ipd_prescriptions.id
        $table->uuid('patient_id')->nullable();

        $table->string('medicine_name');
        $table->uuid('medicine_id')->nullable();

        $table->integer('quantity');
        $table->integer('dispensed_quantity')->default(0);

        $table->uuid('batch_id')->nullable();

        $table->timestamp('dispensed_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_ipd_dispense');
    }
};
