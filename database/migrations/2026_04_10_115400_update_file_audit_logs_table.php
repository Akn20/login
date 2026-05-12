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
    Schema::table('file_audit_logs', function (Blueprint $table) {

        if (!Schema::hasColumn('file_audit_logs', 'report_id')) {
            $table->uuid('report_id')->nullable()->after('id');
        }

        if (!Schema::hasColumn('file_audit_logs', 'sample_id')) {
            $table->string('sample_id')->nullable()->after('report_id');
        }

    });
}

public function down()
{
    Schema::table('file_audit_logs', function (Blueprint $table) {
        $table->dropColumn(['report_id', 'sample_id']);
    });
}
};