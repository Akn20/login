<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('leave_mappings', function (Blueprint $table) {
       $table->string('gender')->nullable()->after('designations');     // Full-time / Part-time
    });
}

public function down(): void
{
    Schema::table('leave_mappings', function (Blueprint $table) {
        $table->dropColumn('gender'); // ✅ only drop gender
    });
}
};
