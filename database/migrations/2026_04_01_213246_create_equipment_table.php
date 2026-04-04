<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('equipment_code')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('manufacturer')->nullable();
            $table->string('model_number')->nullable();
            $table->string('serial_number')->nullable();

            $table->date('installation_date')->nullable();
            $table->string('location')->nullable();

            // CONDITION STATUS (real-world status)
            $table->enum('condition_status', [
                'Active',
                'Under Maintenance',
                'Out of Service'
            ])->default('Active');

            // SYSTEM STATUS (toggle)
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};