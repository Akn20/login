<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->integer('token_number');
            $table->date('token_date');

            $table->uuid('patient_id');
            $table->uuid('doctor_id')->nullable();

            $table->enum('status', [
                'WAITING',
                'IN_PROGRESS',
                'SKIPPED',
                'COMPLETED'
            ])->default('WAITING');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');

            $table->unique(['token_date', 'token_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
