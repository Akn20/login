<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medication_administration', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->unsignedBigInteger('nurse_id');
            $table->uuid('prescription_item_id');

            $table->time('scheduled_time')->nullable();
            $table->dateTime('administered_time')->nullable();

            $table->enum('status', ['pending', 'administered', 'missed'])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('nurse_id')->references('id')->on('staff');
            $table->foreign('prescription_item_id')->references('id')->on('offline_prescription_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_administration');
    }
};
