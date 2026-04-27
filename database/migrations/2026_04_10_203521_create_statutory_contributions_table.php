<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::create('statutory_contributions', function (Blueprint $table) {

            $table->uuid('id')->primary();

            /*
            =========================
            IDENTIFICATION
            =========================
            */

            $table->string('contribution_code')->unique();

            $table->string('contribution_name');

            $table->string('statutory_category');

            $table->string('status');


            /*
            =========================
            RULE MAPPING
            =========================
            */

            $table->string('rule_set_code');

            $table->boolean('eligibility_flag')->default(1);

            $table->boolean('salary_ceiling_applicable')->default(0);

            $table->decimal('salary_ceiling_amount', 10, 2)->nullable();

            $table->boolean('state_applicable')->default(0);

            // Multi-select states
            $table->text('applicable_states')->nullable();


            /*
            =========================
            PAYROLL BEHAVIOUR
            =========================
            */

            $table->boolean('prorata_applicable')->default(1);

            $table->boolean('lop_impact')->default(0);

            $table->string('rounding_rule')->nullable();


            /*
            =========================
            PAYSLIP
            =========================
            */

            $table->boolean('show_in_payslip')->default(1);

            $table->integer('payslip_order')->nullable();


            /*
            =========================
            COST & CTC
            =========================
            */

            $table->boolean('included_in_ctc')->default(1);


            /*
            =========================
            COMPLIANCE
            =========================
            */

            $table->string('compliance_head');

            $table->string('statutory_code');


            /*
            =========================
            SYSTEM
            =========================
            */

            $table->softDeletes();

            $table->timestamps();

        });

    }


    public function down(): void
    {

        Schema::dropIfExists('statutory_contributions');

    }

};