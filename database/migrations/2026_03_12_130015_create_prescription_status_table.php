<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescription_status', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('consultation_id');

            $table->string('status')->default('Pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescription_status');
    }
};
