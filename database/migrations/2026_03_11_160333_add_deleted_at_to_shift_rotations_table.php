<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToShiftRotationsTable extends Migration
{
    public function up(): void
    {
        Schema::table('shift_rotations', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('shift_rotations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}