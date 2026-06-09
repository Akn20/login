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
        Schema::create('patient_alerts', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('hospital_id');

            $table->uuid('patient_id');

            $table->string('alert_type');

            $table->string('title');

            $table->text('message');

            $table->uuid('related_id')->nullable();

            $table->string('related_type')->nullable();

            $table->dateTime('alert_date')->nullable();

            $table->boolean('is_read')->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_alerts');
    }
};