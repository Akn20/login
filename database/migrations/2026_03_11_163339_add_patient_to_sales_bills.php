<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_bills', function (Blueprint $table) {

           // $table->uuid('patient_id')->nullable()->after('bill_number');

           // $table->uuid('prescription_id')->nullable()->after('patient_id');

        });
    }

    public function down(): void
    {
        Schema::table('sales_bills', function (Blueprint $table) {

            $table->dropColumn('patient_id');
            $table->dropColumn('prescription_id');

        });

    }
};
