<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // the enum restriction prevents new values being inserted; convert to simple string
        // note: requires doctrine/dbal for ->change(); if not installed, run:
        // composer require doctrine/dbal
        Schema::table('items', function (Blueprint $table) {
            // change the column type from enum to string
            $table->string('category')->nullable()->change();
        });
    }

    public function down(): void
    {
        // revert back to original enum; existing values which aren't one of the three
        // will be set to 'Medicine' during the change (you may adjust as needed)
        Schema::table('items', function (Blueprint $table) {
            $table->enum('category', ['Medicine', 'Equipment', 'Consumable'])
                  ->default('Medicine')
                  ->change();
        });
    }
};