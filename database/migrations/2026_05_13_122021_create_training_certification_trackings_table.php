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
        Schema::create('training_certification_trackings', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // Employee Info
            $table->string('employee_id');
            $table->string('employee_name');
            $table->string('department')->nullable();
            $table->string('designation')->nullable();

            // Training Details
            $table->string('training_code')->unique();
            $table->string('training_name');
            $table->string('training_type')->nullable();
            $table->string('training_provider')->nullable();
            $table->string('training_location')->nullable();

            $table->date('training_start_date')->nullable();
            $table->date('training_end_date')->nullable();

            // Certification Details
            $table->string('certification_name');
            $table->string('certification_number')->nullable();

            $table->date('issue_date');
            $table->date('expiry_date');

            $table->string('certification_authority')->nullable();

            // Renewal
            $table->boolean('renewal_required')->default(0);

            // Status
            $table->enum('status', [
                'Active',
                'Expiring Soon',
                'Expired',
                'Renewed'
            ])->default('Active');

            // Reminder
            $table->integer('reminder_days')->nullable();

            $table->boolean('reminder_enabled')
                ->default(0);

            // Additional
            $table->text('remarks')->nullable();

            $table->string('attachment')->nullable();

            $table->string('created_by')->nullable();

            $table->string('updated_by')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'training_certification_trackings'
        );
    }
};