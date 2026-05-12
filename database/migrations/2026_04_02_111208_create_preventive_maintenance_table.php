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
       Schema::create('preventive_maintenance', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('equipment_id');

            $table->enum('frequency', ['Monthly', 'Quarterly', 'Yearly']);

            $table->date('next_maintenance_date');

            $table->string('technician')->nullable();

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('preventive_maintenance');
    }
};
