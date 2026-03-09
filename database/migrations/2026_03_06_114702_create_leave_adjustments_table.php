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
    Schema::create('leave_adjustments', function (Blueprint $table) {
    $table->char('id',36)->primary();   // UUID primary key
    $table->char('staff_id',36);
    $table->char('leave_type_id',36);

    $table->integer('credit')->default(0);
    $table->integer('debit')->default(0);

    $table->text('remarks');
    $table->year('year');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_adjustments');
    }
};
