<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biometric_images', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->tinyInteger('slot')->unsigned()->comment('1,2,3');
            $table->string('path');
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['user_id', 'slot']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('biometric_updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biometric_images');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('biometric_updated_at');
        });
    }
};
