<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('critical_value_alerts', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('report_id');
        $table->string('parameter_name');
        $table->double('value');

        $table->double('threshold_min')->nullable();
        $table->double('threshold_max')->nullable();

        $table->uuid('doctor_id')->nullable();

        $table->string('status')->default('Pending'); // Pending / Acknowledged
        $table->timestamp('acknowledged_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critical_value_alerts');
    }
};
