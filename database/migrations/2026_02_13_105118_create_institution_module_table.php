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
            $table->uuid('institution_id');   
            $table->uuid('module_id');       

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
