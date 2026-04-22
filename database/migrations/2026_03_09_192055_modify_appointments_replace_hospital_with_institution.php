<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            // Drop hospital foreign key first
           $table->dropForeign(['hospital_id']);

            // Remove hospital_id column
           $table->dropColumn('hospital_id');

            // Add institution_id
            $table->char('institution_id', 36)->after('consultation_fee');

            // Foreign key
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            // Remove institution_id foreign key
            $table->dropForeign(['institution_id']);
    
            // Drop institution_id
            $table->dropColumn('institution_id');

            // Re-add hospital_id
            $table->char('hospital_id', 36)->after('consultation_fee');

            $table->foreign('hospital_id')
                ->references('id')
                ->on('hospitals')
                ->cascadeOnDelete();
        });
    }
};