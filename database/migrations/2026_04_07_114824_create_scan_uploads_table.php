<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scan_uploads', function (Blueprint $table) {

            $table->id();

            // FK (scan_requests UUID)
            $table->uuid('scan_request_id');

            $table->string('file_path');
            $table->string('file_type')->nullable(); // jpg, pdf, dicom
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('scan_request_id')
                ->references('id')
                ->on('scan_requests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_uploads');
    }
};
