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
        Schema::create('rate_employee_mappings', function (Blueprint $table) {

            // Primary Key (UUID like other modules)

            $table->uuid('id')->primary();

            // Identification

            $table->string('rule_set_code', 50)->unique();
            $table->string('rule_set_name', 100);
            $table->string('work_type_code', 50);

            // Calculation Logic

            $table->string('rate_type', 20);
            $table->string('base_rate_source', 50);

            $table->decimal('base_rate_value', 10, 2)->nullable();
            $table->decimal('multiplier_value', 5, 2)->nullable();

            $table->integer('maximum_hours')->nullable();
            $table->string('round_off_rule', 20)->nullable();

            // Applicability

            $table->string('employee_type', 50);

            $table->uuid('employee_id')->nullable();

            $table->string('employee_category', 50)->nullable();

            // Soft Delete

            $table->softDeletes();

            // Timestamps

            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('rate_employee_mappings');
    }
};