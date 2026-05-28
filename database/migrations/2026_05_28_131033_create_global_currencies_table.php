<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */

    public function up(): void
    {
        Schema::create('global_currencies', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY (UUID)
            |--------------------------------------------------------------------------
            */

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | CURRENCY DETAILS
            |--------------------------------------------------------------------------
            */

            $table->string('currency_name');

            // Example:
            // INR
            // USD
            // EUR

            $table->string('currency_code')->unique();

            // Example:
            // ₹
            // $
            // €

            $table->string('currency_symbol');

            /*
            |--------------------------------------------------------------------------
            | DECIMAL SETTINGS
            |--------------------------------------------------------------------------
            */

            $table->integer('decimal_places')
                  ->default(2);

            /*
            |--------------------------------------------------------------------------
            | DEFAULT CURRENCY
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_default')
                  ->default(false);

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | SOFT DELETE
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();

        });
    }

    /**
     * Reverse migrations
     */

    public function down(): void
    {
        Schema::dropIfExists('global_currencies');
    }
};