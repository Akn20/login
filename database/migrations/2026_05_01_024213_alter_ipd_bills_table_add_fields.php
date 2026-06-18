<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ipd_bills', function (Blueprint $table) {
            $table->decimal('discount_percent', 5, 2)->default(0)->after('total_amount');
            $table->decimal('tax_percent', 5, 2)->default(0)->after('discount_percent');
            $table->char('created_by', 36)->nullable()->after('payable_amount');
            $table->text('notes')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ipd_bills', function (Blueprint $table) {
            $table->dropColumn(['discount_percent', 'tax_percent', 'created_by', 'notes']);
        });
    }
};
