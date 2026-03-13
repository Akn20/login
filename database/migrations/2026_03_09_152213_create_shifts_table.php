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
        Schema::create('shifts', function (Blueprint $table) {

            $table->id();

            $table->string('shift_name');

            $table->time('start_time');

            $table->time('end_time');

            $table->integer('grace_minutes')->nullable();

            $table->integer('break_minutes')->nullable();

            $table->text('remarks')->nullable();

            $table->boolean('status')->default(1);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};