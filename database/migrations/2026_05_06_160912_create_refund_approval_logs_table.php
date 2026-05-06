<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refund_approval_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('refund_id');

            $table->uuid('approver_id');

            $table->enum('approval_status', [
                'Approved',
                'Rejected',
                'Reverify'
            ]);

            $table->text('remarks')->nullable();

            $table->timestamp('action_time')->useCurrent();

            $table->timestamps();

            $table->foreign('refund_id')
                ->references('id')
                ->on('refunds')
                ->cascadeOnDelete();

            $table->foreign('approver_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_approval_logs');
    }
};