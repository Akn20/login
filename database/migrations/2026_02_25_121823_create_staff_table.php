<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Schema::create('staff', function (Blueprint $table) {
    //     $table->id();
    //     $table->string('employee_id')->unique();
    //     $table->string('name');
    //     $table->date('joining_date')->nullable();
    //     $table->string('status')->default('Active');
    //     $table->string('department');
    //     $table->string('designation');
    //     $table->softDeletes();
    //     $table->timestamps();
    // });

    Schema::create('staff', function (Blueprint $table) {
    $table->id();
    $table->string('employee_id')->unique();
    $table->string('name');
    $table->string('department');
    $table->string('designation');
    $table->date('joining_date');
    $table->string('status')->default('Active');
    $table->softDeletes();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
