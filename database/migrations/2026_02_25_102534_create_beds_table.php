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
        Schema::create('beds', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('bed_code');
                $table->uuid('ward_id');   // IMPORTANT (because ward uses UUID)
                $table->string('room_number')->nullable();
                $table->string('bed_type')->nullable();
                $table->string('status');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
