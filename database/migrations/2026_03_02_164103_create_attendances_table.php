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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('date');
            $table->timestamp('checkin_time')->nullable();
            $table->timestamp('checkout_time')->nullable();
            $table->decimal('checkin_lat', 10, 7)->nullable();
            $table->decimal('checkin_lng', 10, 7)->nullable();
            $table->string('status')->default('present');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'date']); // prevent multiple check-ins per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
