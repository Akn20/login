<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
  Schema::create('leave_mappings', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('leave_type_id')->constrained('leave_types')->onDelete('cascade');
    $table->integer('priority')->default(1);
    $table->json('employee_status'); 
    $table->json('designations');

    
        $table->string('employment_type')->nullable();
        $table->string('employee_category')->nullable();
        
        // Accrual Rules
        $table->string('accrual_frequency'); 
        $table->integer('accrual_value');

        // Payroll Impact
        $table->string('leave_nature'); // Paid / Unpaid

        // Carry Forward Rules
        $table->boolean('carry_forward_allowed')->default(false);
        $table->integer('carry_forward_limit')->nullable();
        $table->integer('carry_forward_expiry_days')->nullable();
        // Encashment Rules
        $table->boolean('encashment_allowed')->default(false); //
        $table->string('encashment_trigger')->nullable(); // Year-end / Exit / Specific Date

        // Application Controls
        $table->integer('min_leave_per_application')->default(1);
        $table->integer('max_leave_per_application')->nullable();

        $table->string('status')->default('active'); 
        $table->timestamps();
        $table->softDeletes();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('leave_mappings');
    }
};