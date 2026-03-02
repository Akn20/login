<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {

        Schema::table('controlled_drug', function (Blueprint $table) {

            $table->string('drug_name')
                ->after('drug_id');

            $table->string('status')
                ->default('Active')
                ->after('supplier_id');

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
