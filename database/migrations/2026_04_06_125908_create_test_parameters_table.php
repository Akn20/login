<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('test_parameters', function (Blueprint $table) {
            $table->id();

            $table->string('test_name');
            // Example: Blood test, X-ray

            $table->foreignId('parameter_id')
                ->constrained('parameters')
                ->onDelete('cascade');

            $table->timestamps();

            // Prevent duplicate mapping
            $table->unique(['test_name', 'parameter_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_parameters');
    }
};