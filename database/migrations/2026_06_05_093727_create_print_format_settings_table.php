<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('print_format_settings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('hospital_id');

            $table->string('hospital_logo')->nullable();

            $table->string('hospital_name');

            $table->text('address')->nullable();

            $table->string('phone_number')->nullable();

            $table->text('footer_text')->nullable();

            $table->text('disclaimer')->nullable();

            $table->string('signature_area')->nullable();

            $table->enum('paper_size', [
                'A4',
                'A5',
                'Letter'
            ])->default('A4');

            $table->enum('orientation', [
                'Portrait',
                'Landscape'
            ])->default('Portrait');

            $table->string('margins')->nullable();

            $table->enum('status', [
                'Active',
                'Inactive'
            ])->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_format_settings');
    }
};