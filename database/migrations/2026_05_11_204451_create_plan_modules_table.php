<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('plan_modules', function (Blueprint $table) {

            $table->id();

            $table->uuid('plan_id');

            $table->uuid('module_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_modules');
    }
};