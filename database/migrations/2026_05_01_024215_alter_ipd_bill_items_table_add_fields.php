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
        Schema::table('ipd_bill_items', function (Blueprint $table) {
            $table->string('reference_type')->nullable()->after('type');
            $table->text('description')->change(); // upgrade from varchar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ipd_bill_items', function (Blueprint $table) {
            $table->dropColumn('reference_type');
        });
    }
};
