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
    Schema::table('claim_payments', function (Blueprint $table) {
        $table->string('transaction_reference')->nullable()->after('payment_mode');
    });
}

public function down()
{
    Schema::table('claim_payments', function (Blueprint $table) {
        $table->dropColumn('transaction_reference');
    });
}
};
