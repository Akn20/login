<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refund_audit_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('refund_id');

            $table->string('action_type');

            $table->uuid('performed_by');

            $table->text('action_details')->nullable();

            $table->timestamp('action_time')->useCurrent();

            $table->timestamps();

            $table->foreign('refund_id')
                ->references('id')
                ->on('refunds')
                ->cascadeOnDelete();

            $table->foreign('performed_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_audit_logs');
    }
};