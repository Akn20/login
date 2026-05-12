<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('controlled_drug', function (Blueprint $table) {

            if (!Schema::hasColumn('controlled_drug', 'drug_name')) {

                if (Schema::hasColumn('controlled_drug', 'drug_id')) {
                    $table->string('drug_name')->after('drug_id');
                } else {
                    $table->string('drug_name');
                }
            }

            if (!Schema::hasColumn('controlled_drug', 'status')) {
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
            }
        });
    }


    public function down()
    {

        Schema::table('controlled_drug', function (Blueprint $table) {

            $table->dropColumn('drug_name');

            $table->dropColumn('status');

        });

    }

};
