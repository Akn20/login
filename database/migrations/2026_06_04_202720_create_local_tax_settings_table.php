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
        Schema::create('local_tax_settings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('hospital_id');

            $table->string('tax_name');

            $table->decimal('tax_percentage', 5, 2);

            $table->enum('tax_type', [
                'Inclusive',
                'Exclusive'
            ]);

            $table->string('applicable_on');

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
        Schema::dropIfExists('local_tax_settings');
    }
};