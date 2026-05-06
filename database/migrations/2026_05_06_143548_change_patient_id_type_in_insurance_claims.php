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
    Schema::table('insurance_claims', function (Blueprint $table) {
        $table->dropColumn('patient_id');
    });

    Schema::table('insurance_claims', function (Blueprint $table) {
        $table->uuid('patient_id')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_claims', function (Blueprint $table) {
            //
        });
    }
};
