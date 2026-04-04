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
        Schema::create('sample_collections', function (Blueprint $table) {

            $table->uuid('id')->primary(); 

            $table->uuid('lab_request_id');
            $table->uuid('patient_id');

            $table->string('sample_id')->nullable();
            $table->string('barcode')->nullable();
            $table->dateTime('collection_time')->nullable();

            $table->enum('status', ['Pending','Collected','In Process','Completed','Rejected'])
                ->default('Pending');

            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_collections');
    }
};
