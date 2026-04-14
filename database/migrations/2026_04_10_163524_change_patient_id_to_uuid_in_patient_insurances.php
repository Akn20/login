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
    //Schema::table('patient_insurances', function (Blueprint $table) {

        // Directly change column type
   // DB::statement('ALTER TABLE patient_insurances MODIFY patient_id CHAR(36) NULL'); });

    //Schema::table('patient_insurances', function (Blueprint $table) {

        // Change column type
     //   $table->uuid('patient_id')->nullable()->change();
    //});

    //Schema::table('patient_insurances', function (Blueprint $table) {
    //$table->foreign('patient_id')
      //    ->references('id')
        //  ->on('patients')
          //->onDelete('cascade');
// });

    // Re-add foreign key (optional but recommended)
   // Schema::table('patient_insurances', function (Blueprint $table) {

     //   $table->foreign('patient_id')
       //       ->references('id')->on('patients')->onDelete('cascade');});
}

public function down()
{
   // Schema::table('patient_insurances', function (Blueprint $table) {

     //  DB::statement('ALTER TABLE patient_insurances MODIFY patient_id BIGINT UNSIGNED NULL');
       // $table->unsignedBigInteger('patient_id')->nullable()->change();
    //});
}
};
