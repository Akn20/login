<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surgery_consents', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');

            $table->uuid('surgery_id');

            $table->enum('consent_status', [
                'Granted',
                'Refused',
                'Pending'
            ])->default('Pending');

            $table->text('procedure_explained')->nullable();

            $table->text('risks_explained')->nullable();

            $table->text('remarks')->nullable();

            $table->string('document_path')->nullable();

            $table->timestamp('consent_taken_at');

            $table->uuid('recorded_by')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            $table->foreign('surgery_id')
                ->references('id')
                ->on('surgeries')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surgery_consents');
    }
};