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
        Schema::create('comp_offs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('employee_id');

            $table->date('worked_on');

            $table->decimal('comp_off_credited',5,2);

            $table->date('expiry_date')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comp_offs');
    }
};