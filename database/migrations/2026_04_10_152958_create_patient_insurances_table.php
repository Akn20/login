<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_insurances', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();

            $table->string('insurance_type')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('policy_holder_name')->nullable();

            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            $table->decimal('sum_insured', 12, 2)->nullable();

            $table->string('tpa_name')->nullable();

            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_insurances');
    }
};