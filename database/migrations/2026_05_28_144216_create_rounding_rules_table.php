
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
        Schema::create('rounding_rules', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | UUID PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | MODULE NAME
            |--------------------------------------------------------------------------
            */

            $table->string('module_name');

            /*
            |--------------------------------------------------------------------------
            | ROUNDING TYPE
            |--------------------------------------------------------------------------
            */

            $table->enum('rounding_type', [

                'Round Up',
                'Round Down',
                'Round Half Up',
                'Nearest Decimal'

            ]);

            /*
            |--------------------------------------------------------------------------
            | DECIMAL PRECISION
            |--------------------------------------------------------------------------
            */

            $table->integer('decimal_places')
                  ->default(2);

            /*
            |--------------------------------------------------------------------------
            | ACTIVE STATUS
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                  ->default(true);

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
        Schema::dropIfExists('rounding_rules');
    }
};
