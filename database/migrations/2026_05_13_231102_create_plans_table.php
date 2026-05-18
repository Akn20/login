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
        Schema::create('plans', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | PLAN DETAILS
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->text('description')->nullable();

            $table->decimal('price', 10, 2)->default(0);

            $table->enum('billing_cycle', [
                'monthly',
                'quarterly',
                'yearly',
                'lifetime'
            ])->default('monthly');

            /*
            |--------------------------------------------------------------------------
            | LIMITS
            |--------------------------------------------------------------------------
            */

            $table->integer('max_users')->default(-1);

            $table->integer('max_patients')->default(-1);

            $table->integer('max_staff')->default(-1);

            $table->integer('max_storage_mb')->default(-1);

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};