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
    Schema::create('employee_documents', function (Blueprint $table) {
        $table->id();

        // Link to staff table
        $table->foreignId('staff_id')
              ->constrained('staff')
              ->onDelete('cascade');

        $table->string('document_type');
        $table->string('file_path');

        $table->date('expiry_date')->nullable();

        $table->uuid('uploaded_by')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
