<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mobile');
            $table->string('otp'); // hashed OTP
            $table->timestamp('expires_at');
            $table->tinyInteger('attempts')->default(0);
            $table->tinyInteger('resends')->default(0);
            $table->boolean('used')->default(false);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['mobile', 'used', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
