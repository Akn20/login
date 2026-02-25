
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wards', function (Blueprint $table) {

            // tinyint status column
            $table->tinyInteger('status')
                  ->default(1)
                  ->after('total_beds')
                  ->comment('1=Active, 0=Inactive');

        });
    }

    public function down()
    {
        Schema::table('wards', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};