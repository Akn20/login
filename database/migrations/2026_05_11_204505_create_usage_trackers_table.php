<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('usage_trackers', function (Blueprint $table) {

            $table->id();

            $table->uuid('organization_id');

            $table->integer('current_users')->default(0);

            $table->integer('current_patients')->default(0);

            $table->integer('current_hospitals')->default(0);

            $table->bigInteger('storage_used_mb')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_trackers');
    }
};