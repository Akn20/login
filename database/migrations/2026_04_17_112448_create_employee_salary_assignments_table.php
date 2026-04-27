<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('employee_salary_assignments', function (Blueprint $table) {

        $table->uuid('id')->primary();

        $table->uuid('employee_id');
        $table->uuid('salary_structure_id');

        $table->string('salary_basis');
        $table->decimal('salary_amount', 10, 2);
        $table->string('pay_frequency');
        $table->string('currency')->default('INR');

        $table->boolean('hourly_pay_eligible')->default(0);
        $table->boolean('overtime_eligible')->default(0);
        $table->json('allowed_work_types')->nullable();

        $table->date('effective_from');
        $table->date('effective_to')->nullable();

        $table->string('status');

        $table->uuid('created_by')->nullable();

        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_assignments');
    }
};
