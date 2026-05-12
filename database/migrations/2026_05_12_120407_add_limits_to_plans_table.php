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
    Schema::table('plans', function (Blueprint $table) {

        $table->integer('max_users')
            ->default(-1);

        $table->integer('max_patients')
            ->default(-1);

        $table->integer('max_hospitals')
            ->default(-1);

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            //
        });
    }
};
