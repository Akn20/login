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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('room_number')->unique();
            $table->uuid('ward_id');
            $table->string('room_type');
            $table->integer('total_beds')->default(0);
            $table->enum('status', ['available', 'occupied', 'maintenance', 'cleaning'])
                ->default('available');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ward_id')
                ->references('id')
                ->on('wards')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
