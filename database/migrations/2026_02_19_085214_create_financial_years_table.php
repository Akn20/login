<?php
// database/migrations/xxxx_xx_xx_create_financial_years_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financial_years', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code')->unique();  // e.g. "FY 2024-25"
            $table->date('start_date');
            $table->date('end_date');

            $table->boolean('is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_years');
    }
};
