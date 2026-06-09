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
        Schema::create('prescription_format_settings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('hospital_id');

            $table->string('hospital_logo')->nullable();

            $table->text('header_text')->nullable();

            $table->text('footer_text')->nullable();

            $table->boolean('show_doctor_name')
                  ->default(true);

            $table->boolean('show_doctor_qualification')
                  ->default(true);

            $table->boolean('show_registration_number')
                  ->default(true);

            $table->boolean('show_patient_age')
                  ->default(true);

            $table->boolean('show_patient_gender')
                  ->default(true);

            $table->boolean('show_date')
                  ->default(true);

            $table->enum('paper_size', [
                'A4',
                'A5',
                'Letter'
            ])->default('A4');

            $table->enum('orientation', [
                'Portrait',
                'Landscape'
            ])->default('Portrait');

            $table->integer('margins')
                  ->default(10);

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_format_settings');
    }
};