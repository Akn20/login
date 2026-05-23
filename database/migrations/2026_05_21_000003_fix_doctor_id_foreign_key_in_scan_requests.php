<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all foreign keys and find the one for doctor_id
        $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'scan_requests' AND COLUMN_NAME = 'doctor_id' AND REFERENCED_TABLE_NAME IS NOT NULL");
        
        if (!empty($foreignKeys)) {
            foreach ($foreignKeys as $fk) {
                DB::statement('ALTER TABLE scan_requests DROP FOREIGN KEY ' . $fk->CONSTRAINT_NAME);
            }
        }

        // First make the column nullable so we can clear it
        DB::statement('ALTER TABLE scan_requests MODIFY doctor_id CHAR(36) NULL');
        
        // Clear the doctor_id data
        DB::statement('UPDATE scan_requests SET doctor_id = NULL');

        // Now change doctor_id to unsignedBigInteger nullable
        DB::statement('ALTER TABLE scan_requests MODIFY doctor_id BIGINT UNSIGNED NULL');

        Schema::table('scan_requests', function (Blueprint $table) {
            // Add the correct foreign key referencing staff table
            $table->foreign('doctor_id')
                ->references('id')->on('staff')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all foreign keys and find the one for doctor_id
        $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'scan_requests' AND COLUMN_NAME = 'doctor_id' AND REFERENCED_TABLE_NAME = 'staff'");
        
        if (!empty($foreignKeys)) {
            foreach ($foreignKeys as $fk) {
                DB::statement('ALTER TABLE scan_requests DROP FOREIGN KEY ' . $fk->CONSTRAINT_NAME);
            }
        }

        // Revert doctor_id back to UUID
        DB::statement('ALTER TABLE scan_requests MODIFY doctor_id CHAR(36)');
    }
};
