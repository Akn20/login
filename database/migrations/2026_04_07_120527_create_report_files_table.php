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
        Schema::create('report_files', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('lab_report_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');

            $table->integer('version')->default(1);
            $table->boolean('is_main')->default(false);

            $table->uuid('uploaded_by')->nullable();

            $table->timestamps();

            $table->foreign('lab_report_id')
                ->references('id')
                ->on('lab_reports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_files');
    }
};
