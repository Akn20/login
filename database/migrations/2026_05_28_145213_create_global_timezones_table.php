<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */

    public function up(): void
    {
        Schema::create('global_timezones', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | UUID PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | TIMEZONE DETAILS
            |--------------------------------------------------------------------------
            */

            // Example:
            // Asia/Kolkata
            // UTC
            // America/New_York

            $table->string('timezone_name');

            /*
            |--------------------------------------------------------------------------
            | TIMEZONE CODE
            |--------------------------------------------------------------------------
            */

            // Example:
            // IST
            // UTC
            // EST

            $table->string('timezone_code');

            /*
            |--------------------------------------------------------------------------
            | DATE FORMAT
            |--------------------------------------------------------------------------
            */

            // Example:
            // d-m-Y
            // Y-m-d

            $table->string('date_format')
                  ->default('d-m-Y');

            /*
            |--------------------------------------------------------------------------
            | TIME FORMAT
            |--------------------------------------------------------------------------
            */

            // Example:
            // 12 Hour
            // 24 Hour

            $table->enum('time_format', [

                '12 Hour',
                '24 Hour'

            ])->default('12 Hour');

            /*
            |--------------------------------------------------------------------------
            | DEFAULT TIMEZONE
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
        Schema::dropIfExists('global_timezones');
    }
};
