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
        Schema::create('otps', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('mobile', 10);
    $table->string('otp');
    $table->timestamp('expires_at');
    $table->integer('attempts')->default(0);
    $table->integer('resends')->default(0);
    $table->boolean('used')->default(false);
    $table->timestamp('last_sent_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
