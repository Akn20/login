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
    Schema::table('staff', function (Blueprint $table) {
        $table->decimal('basic_salary', 10, 2)->nullable();
        $table->decimal('hra', 10, 2)->nullable();
        $table->decimal('allowance', 10, 2)->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('staff', function (Blueprint $table) {
        $table->dropColumn(['basic_salary', 'hra', 'allowance']);
    });
}
};
