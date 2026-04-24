<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('critical_value_alerts', function (Blueprint $table) {
            $table->uuid('acknowledged_by')->nullable()->after('doctor_id');
        });
    }

    public function down(): void
    {
        Schema::table('critical_value_alerts', function (Blueprint $table) {
            $table->dropColumn('acknowledged_by');
        });
    }
};