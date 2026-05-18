<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {

            

            $table->decimal('monthly_price', 10, 2)->default(0);

            $table->decimal('yearly_price', 10, 2)->default(0);

            $table->integer('trial_days')->default(0);

            $table->integer('grace_days')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {

            $table->dropColumn([
                'slug',
                'monthly_price',
                'yearly_price',
                'trial_days',
                'grace_days'
            ]);
        });
    }
};