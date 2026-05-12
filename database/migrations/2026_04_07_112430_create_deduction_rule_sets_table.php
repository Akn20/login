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
    Schema::create('deduction_rule_sets', function (Blueprint $table) {
       $table->engine = 'InnoDB';
       $table->uuid('id')->primary();

        $table->string('rule_set_code')->unique();
        $table->string('rule_set_name');
        $table->string('rule_category');
        $table->string('calculation_type');

        $table->string('calculation_base')->nullable();
        $table->decimal('calculation_value', 10, 2)->nullable();
        $table->string('calculation_applies_on')->nullable();

        $table->string('slab_reference')->nullable();

        // ✅ FIXED NAMES
        $table->decimal('maximum_limit', 10, 2)->nullable();
        $table->decimal('minimum_limit', 10, 2)->nullable();

        $table->string('rounding_rule')->nullable();

        $table->boolean('prorata_applicable')->default(0);
        $table->boolean('lop_impact')->default(0);
        $table->boolean('editable_at_payroll')->default(0);
        $table->boolean('skip_if_insufficient_salary')->default(0);

        $table->integer('priority')->nullable();
        $table->decimal('max_percent_net_salary', 10, 2)->nullable();

        $table->date('effective_from');
        $table->date('effective_to')->nullable();

        $table->string('status');
        $table->text('remarks')->nullable();

        $table->softDeletes(); // ✅ IMPORTANT
        $table->timestamps();
        
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deduction_rule_sets');
    }
};
