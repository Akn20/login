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
        Schema::table('hourly_pays', function (Blueprint $table) {

$table->string('payslip_label')->nullable();

$table->string('status')->default('active');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hourly_pays', function (Blueprint $table) {
            //
        });
    }
};
