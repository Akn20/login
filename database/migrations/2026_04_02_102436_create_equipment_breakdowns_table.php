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
        Schema::create('equipment_breakdowns', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('equipment_id');

            $table->text('description');

            $table->string('reported_by');

            $table->date('breakdown_date');

            $table->enum('severity', ['Low', 'Medium', 'High', 'Critical']);

            $table->enum('status', ['Reported', 'Under Repair', 'Resolved'])
                ->default('Reported');

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
        Schema::dropIfExists('equipment_breakdowns');
    }
};
