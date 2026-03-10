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
        Schema::create('bed_allocations', function (Blueprint $table) {

            $table->id(); // auto increment id

            $table->uuid('patient_id');
            $table->uuid('bed_id');

            $table->dateTime('admission_date');
            $table->dateTime('discharge_date')->nullable();

            $table->enum('status', ['Active', 'Transferred', 'Discharged'])
                ->default('Active');

            $table->uuid('allocated_by')->nullable();

            $table->timestamp('created_at')->useCurrent();

            // Foreign Keys
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            $table->foreign('bed_id')
                ->references('id')
                ->on('beds')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_allocations');
    }
};