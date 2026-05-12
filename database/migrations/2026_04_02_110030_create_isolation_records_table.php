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
        Schema::create('isolation_records', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->unsignedBigInteger('nurse_id');

            $table->string('isolation_type'); // Airborne, Contact, Droplet

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->string('status'); // Active / Completed

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isolation_records');
    }
};
