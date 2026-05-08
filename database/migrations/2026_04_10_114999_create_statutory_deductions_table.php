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
    Schema::create('statutory_deductions', function (Blueprint $table) {

    $table->engine = 'InnoDB';

    $table->uuid('id')->primary();

    $table->string('statutory_code')->unique();
    $table->string('statutory_name');
    $table->string('statutory_category');

    $table->foreignUuid('rule_set_id')
          ->nullable()
          ->constrained('deduction_rule_sets')
          ->nullOnDelete();

    $table->boolean('eligibility_flag')->default(false);
    
    $table->boolean('salary_ceiling_applicable')->default(false);
    $table->boolean('state_applicable')->default(false);
    $table->boolean('show_in_payslip')->default(true);
    $table->decimal('salary_ceiling_amount', 10, 2)->nullable();

    $table->json('applicable_states')->nullable();
    

    $table->boolean('prorata_applicable')->default(false);
    $table->boolean('lop_impact')->default(false);

    $table->string('rounding_rule')->nullable();
    $table->integer('payslip_order')->nullable();

    $table->string('compliance_head')->nullable();
    $table->string('authority_code')->nullable();

    $table->enum('status', ['active', 'inactive'])->default('active');

    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statutory_deductions');
    }
};