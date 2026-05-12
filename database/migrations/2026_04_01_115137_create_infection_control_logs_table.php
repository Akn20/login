<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('infection_control_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->unsignedBigInteger('nurse_id');

            $table->string('infection_type');
            $table->string('severity'); // Low, Medium, High
            $table->string('status');   // Active, Recovered

            $table->text('notes')->nullable();

            $table->timestamp('recorded_at')->useCurrent();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infection_control_logs');
    }
};
