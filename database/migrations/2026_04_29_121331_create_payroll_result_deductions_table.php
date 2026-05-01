<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_result_deductions', function (Blueprint $table) {

            // UUID PRIMARY KEY
            $table->uuid('id')->primary();

            // FK → PAYROLL RESULTS
            $table->uuid('payroll_result_id');

            // DEDUCTION DETAILS
            $table->string('deduction_code');

            $table->string('deduction_name');

            $table->enum('deduction_type', [
                'Fixed',
                'Variable',
                'Statutory'
            ]);

            // CALCULATION
            $table->string('rule_set_code')->nullable();

            // calculation base
            $table->enum('calculation_base', [
                'Gross'
            ])->nullable();

            // logic
            $table->enum('calculation_logic', [
                '%',
                'Slab',
                'EMI'
            ])->nullable();

            // percentage / value
            $table->decimal('calculation_value', 10, 2)
                  ->nullable();

            // FINAL AMOUNT
            $table->decimal('amount', 10, 2);

            // CONTROL
            $table->boolean('editable_flag')
                  ->default(1);

            // DISPLAY
            $table->integer('display_order')
                  ->nullable();

            // AUDIT
            $table->uuid('created_by')
                  ->nullable();

            $table->timestamps();

            $table->softDeletes();

            // UNIQUE
            $table->unique(
                ['payroll_result_id', 'deduction_code'],
                'prd_result_code_unique'
            );

            // FK CONSTRAINT
            $table->foreign('payroll_result_id')
                  ->references('id')
                  ->on('payroll_results')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_result_deductions');
    }
};