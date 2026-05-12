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
        Schema::create('hourly_pays', function (Blueprint $table) {

            // 🔹 UUID Primary Key
            $table->uuid('id')->primary();

            // 🔹 Basic Details
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('category');

            // 🔹 Payroll Behaviour
            $table->boolean('is_taxable')->default(false);
            $table->boolean('pf_applicable')->default(false);
            $table->boolean('esi_applicable')->default(false);
            $table->boolean('pt_applicable')->default(false);
            $table->boolean('is_prorata')->default(false);
            $table->boolean('lop_impact')->default(false);

            // 🔹 Earnings Config
            $table->enum('earning_type', ['fixed', 'variable'])->default('fixed');

            // 🔹 Payslip Config
            $table->boolean('show_in_payslip')->default(false);
            $table->integer('display_order')->nullable();

            // 🔹 Timestamps
            $table->timestamps();

            // 🔹 Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hourly_pays');
    }
};