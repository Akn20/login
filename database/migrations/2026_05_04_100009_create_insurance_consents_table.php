<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        Schema::create('insurance_consents', function (Blueprint $table) {

            $table->uuid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | Relations
            |--------------------------------------------------------------------------
            */

            $table->uuid('patient_id');

            $table->uuid('insurance_id');

            $table->uuid('recorded_by')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Consent
            |--------------------------------------------------------------------------
            */

            $table->text('consent_text')->nullable();

            $table->enum('consent_status', [

                'Pending',
                'Approved',
                'Rejected'

            ])->default('Pending');

            $table->timestamp('consent_given_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Document
            |--------------------------------------------------------------------------
            */

            $table->string('document')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Foreign Keys
            |--------------------------------------------------------------------------
            */

            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');

            $table->foreign('insurance_id')
                ->references('id')
                ->on('patient_insurances')
                ->onDelete('cascade');

            $table->foreign('recorded_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_consents');
    }
};