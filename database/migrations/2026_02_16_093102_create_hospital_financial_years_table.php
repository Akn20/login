<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hospital_financial_years', function (Blueprint $table) {
            $table->id();

            $table->char('hospital_id', 36);

            $table->unsignedBigInteger('financial_year_id');
            $table->boolean('is_current')->default(false);
            $table->boolean('locked')->default(false);
            $table->timestamps();

            $table->foreign('financial_year_id')
                ->references('id')
                ->on('financial_years')
                ->onDelete('cascade');

            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
                ->onDelete('cascade');

            $table->unique(['hospital_id', 'financial_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_financial_years');
    }
};
