<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module_label')->unique();
            $table->string('module_display_name');
            $table->string('parent_module')->nullable();
            $table->integer('priority');
            $table->string('icon');
            $table->string('file_url');
            $table->string('page_name');
            $table->string('type');
            $table->string('access_for');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};