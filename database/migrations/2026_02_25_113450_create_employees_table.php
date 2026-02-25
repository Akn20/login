<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Hospital/Institution Links
            $table->uuid('hospital_id')->nullable()->index();
            $table->uuid('institution_id')->nullable()->index();
            
            // Employee Links
            $table->uuid('department_id')->nullable()->index();
            $table->uuid('designation_id')->nullable()->index();
            
            // Employee ID (Unique business ID)
            $table->string('employee_id', 20)->unique();
            
            // Personal Information
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('email')->unique()->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('emergency_contact', 15)->nullable();
            $table->date('date_of_birth');
            $table->string('gender', 10); // Male, Female, Other
            $table->text('address')->nullable();
            
            // Employment Details
            $table->date('joining_date');
            $table->date('confirmation_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('employment_type', 20)->default('Full-time'); // Full-time, Part-time, Contract
            $table->decimal('basic_salary', 12, 2)->nullable();
            $table->decimal('gross_salary', 12, 2)->nullable();
            
            // Status & Flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_confirmed')->default(false);
            $table->string('status_reason')->nullable(); // Resigned, Terminated, etc.
            $table->date('exit_date')->nullable();
            
            // Audit Fields (Your pattern)
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Performance indexes
            $table->index(['institution_id', 'hospital_id'], 'inst_hosp_idx');
            $table->index('employee_id', 'emp_id_idx');
            $table->index('is_active', 'emp_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
