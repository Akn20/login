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
        Schema::create('nurse_shift_handover', function (Blueprint $table) {
            $table->id();
            $table->uuid('hospital_id')->nullable();
            $table->uuid('nurse_id');

            // Existing table reference
            $table->unsignedBigInteger('shift_assignment_id');

            // Handover data
            $table->enum('entry_type', ['note', 'task'])->default('note');
            $table->text('description');
            $table->string('task_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nurse_shift_handover');
    }
};
