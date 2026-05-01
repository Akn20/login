<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_result_earnings', function (Blueprint $table) {

            // PRIMARY KEY (UUID)
            $table->uuid('id')->primary();

            // FK → Payroll Result
            $table->uuid('payroll_result_id');

            $table->foreign('payroll_result_id')
                  ->references('id')
                  ->on('payroll_results')
                  ->onDelete('cascade');

            // Earning Details
            $table->string('earning_code');

            $table->string('earning_name');

            $table->enum('earning_type', [
                'Fixed',
                'Variable',
                'OT'
            ]);

            // Calculation
            $table->string('calculation_base')->nullable();

            $table->string('calculation_value')->nullable();

            $table->decimal('amount', 10, 2);

            // Statutory
            $table->boolean('taxable')->default(1);

            $table->boolean('pf_applicable')->default(0);

            $table->boolean('esi_applicable')->default(0);

            // Display
            $table->integer('display_order')->nullable();

            // Audit
            $table->uuid('created_by')->nullable();

            $table->timestamps();

            $table->softDeletes();

            // UNIQUE RULE
            $table->unique(
                ['payroll_result_id', 'earning_code'],
                'pre_payroll_earning_unique'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_result_earnings');
    }
};