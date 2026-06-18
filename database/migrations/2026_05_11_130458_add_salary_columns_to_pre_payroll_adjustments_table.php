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
    {Schema::table('pre_payroll_adjustments', function (Blueprint $table) {

    $table->decimal('per_day_salary', 10, 2)->nullable();

    $table->decimal('absence_amount', 10, 2)->nullable();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('pre_payroll_adjustments', function (Blueprint $table) {

    $table->dropColumn([
        'per_day_salary',
        'absence_amount'
    ]);

});
    }
};
