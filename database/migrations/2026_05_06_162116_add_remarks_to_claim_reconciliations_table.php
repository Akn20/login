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
    Schema::table('claim_reconciliations', function (Blueprint $table) {
        $table->text('remarks')->nullable();
    });
}

public function down()
{
    Schema::table('claim_reconciliations', function (Blueprint $table) {
        $table->dropColumn('remarks');
    });
}
};
