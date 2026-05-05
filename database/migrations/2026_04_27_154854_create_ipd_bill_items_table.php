<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ipd_bill_items', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('bill_id');

            $table->string('type'); // room, lab, pharmacy, service, manual
            $table->uuid('reference_id')->nullable();

            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);

            $table->timestamps();

            // FK
            // $table->foreign('bill_id')->references('id')->on('ipd_bills')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_bill_items');
    }
};
