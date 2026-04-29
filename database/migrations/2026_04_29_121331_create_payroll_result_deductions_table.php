<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_result_deductions', function (Blueprint $table) {

            $table->id();

            // FK (dummy for now)
            $table->unsignedBigInteger('payroll_result_id');

            // Deduction Details
            $table->string('deduction_code');
            $table->string('deduction_name');

            $table->enum('deduction_type', [
                'Fixed',
                'Variable',
                'Statutory'
            ]);

            // Rule
            $table->string('rule_set_code')->nullable();

            $table->enum('calculation_logic', [
                '%',
                'Slab',
                'EMI'
            ]);

            // Amount
            $table->decimal('amount', 10, 2);

            // Control
            $table->boolean('editable_flag')->default(1);

            // Display
            $table->integer('display_order')->nullable();

            // Audit
            $table->uuid('created_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // UNIQUE
           $table->unique(
    ['payroll_result_id', 'deduction_code'],
    'prd_result_code_unique'
);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_result_deductions');
    }
};