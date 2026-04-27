<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payroll_result_earnings', function (Blueprint $table) {
            $table->id();

// FK (dummy for now)
$table->unsignedBigInteger('payroll_result_id');

// Earning Details
$table->string('earning_code');
$table->string('earning_name');
$table->enum('earning_type', ['Fixed', 'Variable', 'OT']);

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

// ✅ FIXED HERE
$table->uuid('created_by')->nullable();

$table->timestamps();
$table->softDeletes();

// UNIQUE
$table->unique(['payroll_result_id', 'earning_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payroll_result_earnings');
    }
};