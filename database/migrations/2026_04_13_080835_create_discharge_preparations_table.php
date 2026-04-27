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
        Schema::create('discharge_preparations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('hospital_id')->nullable();
            $table->uuid('patient_id');
            $table->uuid('ipd_admission_id');
            $table->uuid('nurse_id');

            $table->json('checklist')->nullable();
            
            $table->boolean('belongings_status')->default(false);

            $table->enum('status', ['pending', 'in_progress', 'ready'])->default('pending');
            $table->boolean('is_ready')->default(false);

            $table->timestamp('prepared_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('patient_id');
            $table->index('ipd_admission_id');
        });
           
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discharge_preparations');
    }
};
