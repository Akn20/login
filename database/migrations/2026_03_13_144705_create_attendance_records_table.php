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
        Schema::create('attendance_records', function (Blueprint $table) {

    $table->id();

    $table->foreignId('employee_id')
          ->constrained('staff')
          ->cascadeOnDelete();

    $table->foreignId('department_id');
    $table->foreignId('designation_id');

    $table->foreignId('shift_id')
          ->constrained('shifts');

    $table->date('attendance_date');

    $table->time('check_in')->nullable();
    $table->time('check_out')->nullable();

    $table->string('status');

    $table->integer('late_minutes')->default(0);
    $table->integer('overtime_minutes')->default(0);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
