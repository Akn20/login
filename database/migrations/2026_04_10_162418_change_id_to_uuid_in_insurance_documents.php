<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    // Step 1: Remove AUTO_INCREMENT
    DB::statement('ALTER TABLE insurance_documents MODIFY id BIGINT UNSIGNED NOT NULL');

    // Step 2: Drop primary key
    DB::statement('ALTER TABLE insurance_documents DROP PRIMARY KEY');

    // Step 3: Drop old column
    Schema::table('insurance_documents', function (Blueprint $table) {
        $table->dropColumn('id');
    });

    // Step 4: Add UUID
    Schema::table('insurance_documents', function (Blueprint $table) {
        $table->uuid('id')->primary()->first();
    });
}

public function down()
{
    Schema::table('insurance_documents', function (Blueprint $table) {
        $table->dropPrimary();
        $table->dropColumn('id');
    });

    Schema::table('insurance_documents', function (Blueprint $table) {
        $table->bigIncrements('id')->first();
    });
}
};
