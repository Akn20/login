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
        Schema::create('offline_prescription_items', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('offline_prescription_id');

            $table->string('medicine_name');

            $table->string('dosage')->nullable();

            $table->string('frequency')->nullable();

            $table->string('duration')->nullable();

            $table->integer('quantity')->nullable();

            $table->text('instructions')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('offline_prescription_id')
                  ->references('id')
                  ->on('offline_prescriptions')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_prescription_items');
    }
};