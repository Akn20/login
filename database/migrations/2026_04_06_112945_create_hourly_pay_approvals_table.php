<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hourly_pay_approvals', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Required timestamps
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hourly_pay_approvals');
    }
};