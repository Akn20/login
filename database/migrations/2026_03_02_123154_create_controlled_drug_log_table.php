<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('controlled_drug_log', function (Blueprint $table) {

            $table->uuid('log_id')->primary();

            $table->uuid('controlled_drug_id');

            $table->string('transaction_type');

            $table->integer('quantity');

            $table->date('transaction_date');

            $table->integer('pharmacist_id');

            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('controlled_drug_log');
    }
};
