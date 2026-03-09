<?php

// database/migrations/xxxx_xx_xx_create_hospital_financial_years_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hospital_financial_years', function (Blueprint $table) {
            $table->char('hospital_id', 36);
            $table->char('financial_year_id', 36);

            $table->boolean('is_current')->default(false);
            $table->boolean('locked')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hospital_id')
                ->references('id')->on('hospitals')
                ->onDelete('cascade');

            $table->foreign('financial_year_id')
                ->references('id')->on('financial_years')
                ->onDelete('cascade');

            $table->unique(['hospital_id', 'financial_year_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_financial_years');
    }
};
