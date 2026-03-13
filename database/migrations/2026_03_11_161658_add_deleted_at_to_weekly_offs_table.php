<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToWeeklyOffsTable extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_offs', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('weekly_offs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}