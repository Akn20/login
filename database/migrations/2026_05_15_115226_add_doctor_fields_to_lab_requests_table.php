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
        Schema::table('lab_requests', function (Blueprint $table) {

    $table->uuid('doctor_id')->nullable()->after('patient_id');

    $table->string('department')->nullable()->after('doctor_id');

    $table->text('clinical_notes')->nullable()->after('priority');

    $table->text('doctor_remarks')->nullable()->after('clinical_notes');

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            //
        });
    }
};
