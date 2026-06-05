<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_structures', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('tax_name');

            $table->decimal('tax_percentage', 5, 2);

            $table->enum('tax_type', [
                'GST',
                'CGST',
                'SGST',
                'IGST',
                'VAT'
            ]);

            $table->enum('calculation_type', [
                'Inclusive',
                'Exclusive'
            ])->default('Exclusive');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_structures');
    }
};