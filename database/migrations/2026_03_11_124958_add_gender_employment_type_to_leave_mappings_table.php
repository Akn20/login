<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_mappings', function (Blueprint $table) {

            if (!Schema::hasColumn('leave_mappings', 'gender')) {
                $table->string('gender')->nullable()->after('designations');
            }

            if (!Schema::hasColumn('leave_mappings', 'employment_type')) {
                $table->string('employment_type')->nullable()->after('gender');
            }

        });
    }

    public function down(): void
    {
        Schema::table('leave_mappings', function (Blueprint $table) {

            $table->dropColumn(['gender','employment_type']);

        });
    }
};
