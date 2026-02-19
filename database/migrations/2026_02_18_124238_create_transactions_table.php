<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Match types of hospitals.id and financial_years.id
            $table->char('hospital_id', 36);
            $table->unsignedBigInteger('financial_year_id');

            // Example business fields (minimal for now)
            $table->string('reference')->nullable();
            $table->decimal('amount', 12, 2)->nullable();

            $table->timestamps();

            $table->foreign('hospital_id')
                ->references('id')->on('hospitals')
                ->onDelete('cascade');

            $table->foreign('financial_year_id')
                ->references('id')->on('financial_years')
                ->onDelete('cascade');

            // Optional index for performance
            $table->index(['hospital_id', 'financial_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};