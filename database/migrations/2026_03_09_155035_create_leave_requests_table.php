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
        Schema::create('leave_requests', function (Blueprint $table) {

$table->uuid('id')->primary();

$table->foreignId('employee_id');
$table->uuid('leave_type_id');

$table->date('from_date');
$table->date('to_date');

$table->enum('from_session',['full','first_half','second_half'])->default('full');
$table->enum('to_session',['full','first_half','second_half'])->default('full');

$table->decimal('total_leave_days',5,2);

$table->text('purpose')->nullable();
$table->string('attachment')->nullable();

$table->decimal('calculated_leave_days',5,2)->nullable();

$table->decimal('balance_before',5,2)->nullable();
$table->decimal('balance_after',5,2)->nullable();

$table->enum('status',['pending','approved','rejected','withdrawn'])->default('pending');

$table->integer('current_approval_level')->default(1);
$table->timestamps();
$table->foreign('employee_id')->references('id')->on('staff')->onDelete('cascade');
$table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
