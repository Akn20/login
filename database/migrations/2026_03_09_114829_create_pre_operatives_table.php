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
        Schema::create('pre_operatives', function (Blueprint $table) {

            $table->id();

            $table->uuid('surgery_id');

            $table->string('bp')->nullable();

            $table->string('heart_rate')->nullable();

            $table->text('allergies')->nullable();

            $table->boolean('consent_obtained')->default(false);

            $table->string('fasting_status')->nullable();

            $table->text('instructions')->nullable();

            $table->text('risk_factors')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_operatives');
    }
};