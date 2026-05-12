<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('name');

            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->decimal('monthly_price', 10, 2)->default(0);

            $table->decimal('yearly_price', 10, 2)->default(0);

            $table->integer('trial_days')->default(0);

            $table->integer('grace_days')->default(0);

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};