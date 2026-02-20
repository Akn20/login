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
        Schema::create('designation_master', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('designation_code', 20)->unique();
            $table->string('designation_name', 100);
            $table->uuid('department_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designation_master');
    }
};
