<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_documents', function (Blueprint $table) {

            $table->id();

            $table->uuid('insurance_id');
            $table->string('document_type')->nullable();
            $table->string('file_path')->nullable();

            $table->timestamp('uploaded_at')->useCurrent();

            // Foreign Key
            $table->foreign('insurance_id')
                  ->references('id')
                  ->on('patient_insurances')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_documents');
    }
};