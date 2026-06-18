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
        $table->enum('status', [
            'pending',
            'approved',
            'partial',
            'rejected'
        ])->default('pending')->after('claim_date');
    });
}

public function down()
{
    Schema::table('insurance_claims', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
