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
        Schema::table('lab_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('lab_reports', 'verification_status')) {
                $table->string('verification_status')->default('Pending')->after('status');
            }
            if (!Schema::hasColumn('lab_reports', 'verified_by')) {
                $table->uuid('verified_by')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('lab_reports', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (!Schema::hasColumn('lab_reports', 'verification_notes')) {
                $table->text('verification_notes')->nullable()->after('verified_at');
            }
            if (!Schema::hasColumn('lab_reports', 'digital_signature')) {
                $table->text('digital_signature')->nullable()->after('verification_notes');
            }
            if (!Schema::hasColumn('lab_reports', 'finalized_at')) {
                $table->timestamp('finalized_at')->nullable()->after('digital_signature');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lab_reports', function (Blueprint $table) {
            $columns = [
                'verification_status',
                'verified_by',
                'verified_at',
                'verification_notes',
                'digital_signature',
                'finalized_at',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('lab_reports', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
