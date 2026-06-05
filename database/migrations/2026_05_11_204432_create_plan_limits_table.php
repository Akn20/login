<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('plan_limits', function (Blueprint $table) {

            $table->id();

            $table->uuid('plan_id');

            $table->integer('max_users')->nullable();

            $table->integer('max_patients')->nullable();

            $table->integer('max_hospitals')->nullable();

            $table->bigInteger('max_storage_mb')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_limits');
    }
};