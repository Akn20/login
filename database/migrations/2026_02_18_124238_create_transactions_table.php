<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('hospital_id', 36);        // matches hospitals.id
            $table->char('financial_year_id', 36);  // must match financial_years.id

            $table->string('reference')->nullable();
            $table->decimal('amount', 12, 2)->nullable();

            $table->timestamps();

            $table->foreign('hospital_id')
                ->references('id')->on('hospitals')
                ->onDelete('cascade');

            $table->foreign('financial_year_id')
                ->references('id')->on('financial_years')
                ->onDelete('cascade');

            $table->index(['hospital_id', 'financial_year_id']);
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};