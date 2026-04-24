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
        Schema::create('ipd_notes', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('ipd_id', 36); // link to ipd_admissions
            $table->char('doctor_id', 36)->nullable();

            $table->text('notes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_notes');
    }
};
