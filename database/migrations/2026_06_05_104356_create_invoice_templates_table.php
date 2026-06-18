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
    Schema::create('invoice_templates', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('hospital_id');

        $table->string('template_name');

        $table->string('invoice_prefix')->nullable();

        $table->integer('starting_number')
              ->default(1);

        $table->boolean('show_logo')
              ->default(true);

        $table->boolean('show_address')
              ->default(true);

        $table->boolean('show_phone')
              ->default(true);

        $table->boolean('show_gst')
              ->default(false);

        $table->text('terms_conditions')
              ->nullable();

        $table->enum('status', ['Active', 'Inactive'])
              ->default('Active');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_templates');
    }
};
