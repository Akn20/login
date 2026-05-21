<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_sheets', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');

            $table->uuid('doctor_id');

            $table->uuid('opd_id')->nullable();

            $table->uuid('ipd_id')->nullable();

            $table->enum('visit_type', ['OPD', 'IPD']);

            $table->text('symptoms')->nullable();

            $table->text('diagnosis')->nullable();

            $table->text('clinical_notes')->nullable();

            $table->enum('status', [
                'Active',
                'Completed',
                'Discharged'
            ])->default('Active');

            $table->timestamps();

            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_sheets');
    }
};