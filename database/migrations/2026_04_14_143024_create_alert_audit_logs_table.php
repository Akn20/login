<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_audit_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('alert_id'); // link to critical_value_alerts
            $table->uuid('user_id')->nullable(); // who performed action

            $table->string('action'); 
            // examples: CREATED, VIEWED, ACKNOWLEDGED

            $table->text('remarks')->nullable(); // optional notes

            $table->timestamp('timestamp'); // action time

            $table->timestamps();

            // foreign key (optional but good)
            $table->foreign('alert_id')
                  ->references('id')
                  ->on('critical_value_alerts')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_audit_logs');
    }
};