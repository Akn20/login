<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_rotations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnDelete();

            $table->foreignId('first_shift_id')
                ->constrained('shifts')
                ->cascadeOnDelete();

            $table->foreignId('second_shift_id')
                ->constrained('shifts')
                ->cascadeOnDelete();

            $table->integer('rotation_days');

            $table->date('start_date');

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_rotations');
    }
};