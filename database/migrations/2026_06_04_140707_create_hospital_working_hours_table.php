<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_working_hours', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('hospital_id');

            $table->time('opening_time');

            $table->time('closing_time');

            $table->time('break_start')->nullable();

            $table->time('break_end')->nullable();

            $table->boolean('emergency_24x7')->default(false);

            $table->enum('status', ['Active', 'Inactive'])
                  ->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_working_hours');
    }
};