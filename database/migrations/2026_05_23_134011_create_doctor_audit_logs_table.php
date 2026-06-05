<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_audit_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id')->nullable();

            $table->uuid('doctor_id')->nullable();

            $table->string('module_name');

            $table->string('action_type');

            $table->json('old_value')->nullable();

            $table->json('new_value')->nullable();

            $table->string('ip_address')->nullable();

            $table->text('device_info')->nullable();

            $table->timestamps();

            $table->index('patient_id');

            $table->index('doctor_id');

            $table->index('module_name');

            $table->index('action_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_audit_logs');
    }
};