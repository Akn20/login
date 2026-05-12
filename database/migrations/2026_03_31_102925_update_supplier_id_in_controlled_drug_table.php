<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('controlled_drug', function (Blueprint $table) {
            $table->char('supplier_id', 36)->change();
        });
    }

    public function down()
    {
        Schema::table('controlled_drug', function (Blueprint $table) {
            $table->bigInteger('supplier_id')->change();
        });
    }
};
