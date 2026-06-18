<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medical_certifications', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Employee
            $table->string('employee_id');
            $table->string('employee_name');
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            // Certificate
            $table->string('certificate_number')->unique();

            $table->enum('certificate_type', [
                'Sick Leave',
                'Fitness',
                'Insurance'
            ]);

            $table->date('issue_date');
            $table->date('valid_from');
            $table->date('valid_until');

            $table->text('diagnosis_reason')->nullable();
            $table->text('medical_remarks')->nullable();

            // Doctor
            $table->string('doctor_name');
            $table->string('registration_number');
            $table->string('hospital_name');
              // Signature
            $table->boolean('signature_status')->default(0);
            $table->string('signed_by')->nullable();
            $table->dateTime('signed_at')->nullable();

            // Status
            $table->enum('status', [
                'Draft',
                'Signed',
                'Cancelled',
                'Expired'
            ])->default('Draft');

            $table->text('remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }
 public function down()
    {
        Schema::dropIfExists('medical_certifications');
    }
};
