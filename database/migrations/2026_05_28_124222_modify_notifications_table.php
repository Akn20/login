<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('notifications', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | NEW COLUMNS
            |--------------------------------------------------------------------------
            */

            $table->uuid('patient_id')
                  ->nullable()
                  ->after('user_id');

            $table->string('type')
                  ->nullable()
                  ->after('patient_id');

            $table->string('title')
                  ->nullable()
                  ->after('type');

            $table->enum('priority', [
                'Low',
                'Medium',
                'High'
            ])
            ->default('Medium')
            ->after('message');

            $table->uuid('reference_id')
                  ->nullable()
                  ->after('priority');

        });

    }

    public function down(): void
    {

        Schema::table('notifications', function (Blueprint $table) {

            $table->dropColumn([
                'patient_id',
                'type',
                'title',
                'priority',
                'reference_id'
            ]);

        });

    }
};