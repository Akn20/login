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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->unique();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->uuid('role_id')->nullable();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

            $table->uuid('department_id')->nullable();
            $table->uuid('designation_id')->nullable();

            // foreign keys
            $table->foreign('department_id')
                ->references('id')
                ->on('department_master')
                ->onDelete('set null');

            $table->foreign('designation_id')
                ->references('id')
                ->on('designation_master')
                ->onDelete('set null');
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
