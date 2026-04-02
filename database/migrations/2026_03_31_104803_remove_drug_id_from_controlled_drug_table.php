<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasColumn('controlled_drug', 'drug_id')) {
            Schema::table('controlled_drug', function (Blueprint $table) {
                $table->dropColumn('drug_id');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('controlled_drug', 'drug_id')) {
            Schema::table('controlled_drug', function (Blueprint $table) {
                $table->string('drug_id')->nullable();
            });
        }
    }
};
