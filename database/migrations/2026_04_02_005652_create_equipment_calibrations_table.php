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
        Schema::create('equipment_calibrations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('equipment_id');

            $table->string('calibration_type');

            $table->date('calibration_date');

            $table->string('technician')->nullable();

            $table->enum('result', ['Pass', 'Fail']);

            $table->date('next_due_date')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes(); // ✅ INCLUDED

            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipment')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_calibrations');
    }
};
