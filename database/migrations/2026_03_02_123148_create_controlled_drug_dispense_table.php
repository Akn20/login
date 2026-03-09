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
        Schema::create('controlled_drug_dispense', function (Blueprint $table) {

            $table->uuid('dispense_id')->primary();

            $table->uuid('controlled_drug_id');

            $table->integer('patient_id');

            $table->integer('prescription_id');

            $table->integer('quantity_dispensed');

            $table->date('dispense_date');

            $table->integer('pharmacist_id');

            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('controlled_drug_dispense');
    }
};
