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
    Schema::create('radiology_reports', function (Blueprint $table) {

        $table->id();

        // FK (UUID)
        $table->uuid('scan_request_id');

        $table->text('observations')->nullable();
        $table->text('findings')->nullable();
        $table->text('diagnosis')->nullable();

        $table->enum('status', ['Pending','Approved','Rejected'])->default('Pending');

        $table->uuid('radiologist_id'); // users table (UUID)

        $table->timestamps();

        $table->foreign('scan_request_id')
            ->references('id')->on('scan_requests')
            ->onDelete('cascade');

        $table->foreign('radiologist_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiology_reports');
    }
};
