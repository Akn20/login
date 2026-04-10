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
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('equipment_id');

            $table->enum('maintenance_type', ['Preventive', 'Corrective']);

            $table->date('maintenance_date');

            $table->string('technician')->nullable(); // simple for now

            $table->text('description')->nullable();

            $table->enum('status', ['Pending', 'In Progress', 'Completed'])
                ->default('Pending');

            $table->timestamps();

            $table->foreign('equipment_id')
                ->references('id')
                ->on('equipment')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};
