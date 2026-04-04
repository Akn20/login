<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lab_reports', function (Blueprint $table) {

            // UUID Primary Key
            $table->uuid('id')->primary();

            // Relation (ONLY REQUIRED FIELD)
            $table->uuid('sample_id');

            // Foreign Key
            $table->foreign('sample_id')
                  ->references('id')
                  ->on('sample_collections')
                  ->onDelete('cascade');

            // Result Data
            $table->json('result_data')->nullable();

            // Status
            $table->enum('status', ['Draft', 'In Progress', 'Completed'])
                  ->default('Draft');

            // Audit
            $table->timestamp('entered_at')->nullable();

            // One report per sample
            $table->unique('sample_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lab_reports');
    }
};