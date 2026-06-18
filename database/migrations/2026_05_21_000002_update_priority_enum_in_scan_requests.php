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
        // First, change column to VARCHAR to remove enum constraint
        DB::statement("ALTER TABLE scan_requests MODIFY priority VARCHAR(255)");
        
        // Update existing data to match new enum values
        DB::statement("UPDATE scan_requests SET priority = 'routine' WHERE priority = 'Normal' OR priority IS NULL");
        DB::statement("UPDATE scan_requests SET priority = 'urgent' WHERE priority = 'Urgent'");
        
        // Now change back to enum with new values
        DB::statement("ALTER TABLE scan_requests MODIFY priority ENUM('routine', 'urgent', 'stat') DEFAULT 'routine'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE scan_requests MODIFY priority VARCHAR(255)");
        DB::statement("UPDATE scan_requests SET priority = 'Normal' WHERE priority = 'routine'");
        DB::statement("UPDATE scan_requests SET priority = 'Urgent' WHERE priority = 'urgent' OR priority = 'stat'");
        DB::statement("ALTER TABLE scan_requests MODIFY priority ENUM('Normal', 'Urgent') DEFAULT 'Normal'");
    }
};
