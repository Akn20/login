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
       Schema::create('leave_request_approvals', function (Blueprint $table) {

    $table->uuid('id')->primary();

    $table->uuid('leave_request_id');
    $table->uuid('approver_id');

    $table->integer('level');

    $table->enum('status',['pending','approved','rejected']);

    $table->text('remarks')->nullable();

    $table->timestamps();
    $table->foreign('leave_request_id')->references('id')->on('leave_requests')->cascadeOnDelete();
    $table->foreign('approver_id')->references('id')->on('users')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave__request__approvals');
    }
};
