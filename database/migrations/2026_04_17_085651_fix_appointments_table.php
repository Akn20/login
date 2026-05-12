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
        Schema::table('appointments', function (Blueprint $table) {

    // Drop column directly (this will also remove FK if exists)
    if (Schema::hasColumn('appointments', 'hospital_id')) {
        $table->dropColumn('hospital_id');
    }

    // Add new column
    if (!Schema::hasColumn('appointments', 'institution_id')) {
        $table->uuid('institution_id')->nullable()->after('consultation_fee');
    }
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
