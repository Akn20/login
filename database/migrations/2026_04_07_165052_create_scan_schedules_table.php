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
    Schema::create('scan_schedules', function (Blueprint $table) {
        $table->id();

        $table->uuid('scan_request_id');
        $table->date('scan_date');
        $table->time('scan_time');

        $table->uuid('technician_id')->nullable();

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
        Schema::dropIfExists('scan_schedules');
    }
};
