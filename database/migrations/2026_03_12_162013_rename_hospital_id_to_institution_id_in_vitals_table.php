<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            $table->renameColumn('hospital_id', 'institution_id');
        });
    }

    public function down(): void
    {
        Schema::table('vitals', function (Blueprint $table) {
            $table->renameColumn('institution_id', 'hospital_id');
        });
    }
};
