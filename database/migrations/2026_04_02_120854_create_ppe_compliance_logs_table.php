<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ppe_compliance_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->unsignedBigInteger('nurse_id');

            $table->boolean('ppe_used'); // 1 = Yes, 0 = No
            $table->string('ppe_type')->nullable(); // Mask, Gloves, etc.

            $table->string('compliance_status'); // Compliant / Non-compliant

            $table->text('notes')->nullable();

            $table->timestamp('recorded_at')->useCurrent();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppe_compliance_logs');
    }
};
