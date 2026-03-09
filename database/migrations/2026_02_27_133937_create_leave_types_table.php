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
        Schema::create('leave_types', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('display_name');
            $table->text('description')->nullable();

            // Duration Rules
            $table->boolean('allow_half_day')->default(false);
            $table->decimal('min_leave_unit', 2, 1)->default(1);
            $table->integer('max_continuous_days')->nullable();

            // Calendar Rules
            $table->boolean('count_weekends')->default(false);
            $table->boolean('count_holidays')->default(false);
            $table->boolean('sandwich_enabled')->default(false);
            $table->string('sandwich_applies_on')->nullable();

            // Application Rules
            $table->boolean('approval_required')->default(true);
            $table->string('approval_level')->default('Single');
            $table->boolean('allow_backdate')->default(false);
            $table->integer('max_backdate_days')->nullable();

            // Attendance Mapping
            $table->string('attendance_code')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};