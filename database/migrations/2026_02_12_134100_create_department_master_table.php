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
        Schema::create('department_master', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('department_code', 20)->unique();
            $table->string('department_name', 100)->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_master');
    }
};
