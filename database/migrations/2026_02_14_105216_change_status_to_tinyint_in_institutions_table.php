<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
        });
    }
};