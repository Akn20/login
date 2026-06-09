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
        Schema::create('emergency_contacts', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('hospital_id');

            $table->string('contact_type');

            $table->string('contact_name');

            $table->string('mobile_no');

            $table->string('alternate_no')->nullable();

            $table->string('email')->nullable();

            $table->text('address')->nullable();

            $table->enum('status', ['Active', 'Inactive'])
                  ->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};