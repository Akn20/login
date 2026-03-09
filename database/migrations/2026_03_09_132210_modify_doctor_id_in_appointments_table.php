<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            // drop old column
            $table->dropColumn('doctor_id');

        });

        Schema::table('appointments', function (Blueprint $table) {

            // recreate doctor_id with correct type
            $table->unsignedBigInteger('doctor_id')->after('patient_id');

            $table->foreign('doctor_id')
                ->references('id')
                ->on('staff')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->dropForeign(['doctor_id']);
            $table->dropColumn('doctor_id');

            // revert back to uuid
            $table->uuid('doctor_id')->after('patient_id');

        });
    }
};