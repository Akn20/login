<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ipd_payments', function (Blueprint $table) {

            $table->id();

            // UUID Foreign Keys
            $table->uuid('patient_id');
            $table->uuid('ipd_id');

            $table->decimal('amount', 10, 2);
            $table->string('payment_mode');

            $table->enum('transaction_type', ['advance', 'additional'])->default('advance');

            $table->timestamps();

            // Indexes
            $table->index('patient_id');
            $table->index('ipd_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ipd_payments');
    }
};