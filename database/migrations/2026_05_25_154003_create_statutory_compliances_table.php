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
      Schema::create('statutory_compliances', function (Blueprint $table) {

    $table->uuid('id')->primary();

    // Employee Information
    $table->string('employee_id');
    $table->string('employee_name');
    $table->string('department');

    // PF Details
    $table->string('pf_applicable')->nullable();
    $table->string('pf_number')->nullable();
    $table->decimal('pf_amount', 10, 2)->nullable();
    $table->date('pf_start_date')->nullable();

    // ESI Details
    $table->string('esi_applicable')->nullable();
    $table->string('esi_number')->nullable();
    $table->decimal('esi_amount', 10, 2)->nullable();

    // Professional Tax
    $table->string('pt_applicable')->nullable();
    $table->decimal('pt_amount', 10, 2)->nullable();
    $table->string('state_applicable')->nullable();

    // TDS Details
    $table->string('tds_applicable')->nullable();
    $table->string('pan_number')->nullable();
    $table->decimal('tds_percentage', 5, 2)->nullable();

    // Contract Details
    $table->date('contract_start_date')->nullable();
    $table->date('contract_end_date')->nullable();
    $table->string('contract_status')->nullable();

    // Medical License
    $table->string('license_number')->nullable();
    $table->date('license_issue_date')->nullable();
    $table->date('license_expiry_date')->nullable();
    $table->string('license_upload')->nullable();
    $table->string('license_status')->nullable();

    // Additional Information
    $table->text('remarks')->nullable();
    $table->string('status')->default('Active');

    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statutory_compliances');
    }
};
