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
        Schema::create('tokens', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('appointment_id');

            $table->integer('token_number');
 
            $table->enum('status', [
                 'WAITING',
                'SKIPPED',
                'COMPLETED'
             ])->default('WAITING');

             $table->timestamps();

            // Foreign Key
            $table->foreign('appointment_id')
                ->references('id')
                ->on('appointments')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
 };