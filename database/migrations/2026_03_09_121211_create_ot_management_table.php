<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ot_management', function (Blueprint $table) {

            $table->id();

            $table->uuid('surgery_id');

            $table->string('ot_room_used')->nullable();

            $table->time('start_time')->nullable();

            $table->time('end_time')->nullable();

            $table->string('equipment_used')->nullable();

            $table->enum('approval_status',['Approved','Not Approved'])->default('Not Approved');

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ot_management');
    }
};