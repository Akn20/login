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
        Schema::create('ipd_discharges', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('ipd_id', 36);

            $table->text('diagnosis')->nullable();
            $table->text('treatment_given')->nullable();
            $table->text('medication_advice')->nullable();
            $table->text('follow_up')->nullable();

            $table->string('doctor_name')->nullable();
            $table->date('date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_discharges');
    }
};
