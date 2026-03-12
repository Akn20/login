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
        Schema::create('leave_applications', function (Blueprint $table) {

            // Primary key
            $table->uuid('id')->primary();

            // Staff reference
            $table->unsignedBigInteger('staff_id');

            // Leave type reference
            $table->char('leave_type_id', 36);

            // Leave duration
            $table->enum('leave_duration', [
                'full_day',
                'first_half',
                'second_half'
            ])->default('full_day');

            // Leave dates
            $table->date('from_date');
            $table->date('to_date');

            // Calculated leave days
            $table->decimal('leave_days', 4, 1);

            // Reason for leave
            $table->text('reason')->nullable();

            // Attachment
            $table->string('attachment')->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'withdrawn'
            ])->default('pending');

            // timestamps
            $table->timestamps();

            // soft delete
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Foreign Keys
            |--------------------------------------------------------------------------
            */

            $table->foreign('staff_id')
                ->references('id')
                ->on('staff')
                ->cascadeOnDelete();

            $table->foreign('leave_type_id')
                ->references('id')
                ->on('leave_types')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applications');
    }
};