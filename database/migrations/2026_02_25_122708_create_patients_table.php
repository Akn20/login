<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('institution_id')->nullable()->change();

            $table->string('patient_code')->unique(); // Display ID
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('date_of_birth');
            $table->string('mobile', 15);
            $table->string('email')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact')->nullable();

            $table->boolean('is_vip')->default(false);
            $table->boolean('status')->default(true);

            $table->uuid('merged_to')->nullable(); // For merge reference

            $table->uuid('created_by')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
