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
        Schema::create('institution_module', function (Blueprint $table) {
            // institutions.id = BIGINT(20) UNSIGNED
            $table->unsignedBigInteger('institution_id');

            // modules.id = CHAR(36)
            $table->char('module_id', 36);

            $table->primary(['institution_id', 'module_id']);

            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('cascade');

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_module');
    }
};
