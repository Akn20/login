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
        Schema::create('controlled_drug', function (Blueprint $table) {

            $table->uuid('controlled_drug_id')->primary();

            // $table->integer('drug_id');

            $table->string('batch_number');

            $table->date('expiry_date');

            $table->integer('stock_quantity');

            $table->integer('supplier_id');

            $table->timestamps();

            $table->softDeletes();


        });
    }


    public function down()
    {
        Schema::dropIfExists('controlled_drug');
    }
};
