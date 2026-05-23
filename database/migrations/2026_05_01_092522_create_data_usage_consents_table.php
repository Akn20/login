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
        Schema::create('data_usage_consents', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');

            $table->enum('purpose', [

                'Treatment',
                'Billing',
                'Insurance',
                'Research',
                'Internal Usage'

            ]);

            $table->enum('consent_status', [

                'Granted',
                'Refused',
                'Pending'

            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->string('document_path')->nullable();

            $table->timestamp('consent_taken_at');

            $table->uuid('recorded_by')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_usage_consents');
    }
};