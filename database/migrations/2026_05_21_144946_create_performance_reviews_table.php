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
    Schema::create('performance_reviews', function (Blueprint $table) {

        $table->uuid('id')->primary();

        $table->string('employee_id');
        $table->string('employee_name');
        $table->string('department');

        $table->string('reviewer_name');

        $table->date('review_date');

        $table->integer('rating');

        $table->text('review_comments')->nullable();

        $table->string('review_status')->default('Pending');

        $table->string('cycle_name')->nullable();

        $table->date('cycle_start_date')->nullable();

        $table->date('cycle_end_date')->nullable();

        $table->string('kpi_name')->nullable();

        $table->integer('target_value')->nullable();

        $table->integer('achieved_value')->nullable();

        $table->integer('kpi_score')->nullable();

        $table->text('kpi_remarks')->nullable();

        $table->string('old_designation')->nullable();

        $table->string('new_designation')->nullable();

        $table->date('promotion_date')->nullable();

        $table->text('promotion_reason')->nullable();

        $table->string('warning_type')->nullable();

        $table->date('warning_date')->nullable();

        $table->text('warning_remarks')->nullable();

        $table->string('issued_by')->nullable();

        $table->text('action_history')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
