<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('user_id')->nullable();

            $table->string('module'); 
            // sample | result | report | alert

            $table->string('action'); 
            // CREATED | UPDATED | VERIFIED | VIEWED | etc.

            $table->uuid('reference_id')->nullable();

            $table->text('description')->nullable();

            $table->timestamp('performed_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};