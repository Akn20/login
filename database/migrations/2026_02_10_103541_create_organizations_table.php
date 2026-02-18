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
        
        Schema::create('organizations', function (Blueprint $table) {
    $table->uuid('id')->primary();

    // Organization Master
    $table->string('name');
    $table->string('type')->nullable();
    $table->string('registration_number')->nullable();
    $table->string('gst')->nullable();

    $table->text('address')->nullable();
    $table->string('city')->nullable();
    $table->string('state')->nullable();
    $table->string('country')->nullable();
    $table->string('pincode')->nullable();

    $table->string('contact_number')->nullable();
    $table->string('email')->nullable();
    $table->string('timezone')->nullable();

    // Access & Branding
    $table->string('organization_url')->nullable();
    $table->string('software_url')->nullable();
    $table->string('logo')->nullable();
    $table->string('language')->default('English');

    // Admin Details
    $table->string('admin_name')->nullable();
    $table->string('admin_email')->nullable();
    $table->string('admin_mobile')->nullable();

    $table->boolean('status')->default(true);

    // Legal
    $table->string('mou_copy')->nullable();
    $table->string('po_number')->nullable();
    $table->date('po_start_date')->nullable();
    $table->date('po_end_date')->nullable();
    $table->string('plan_type')->nullable();
    $table->text('enabled_modules')->nullable();

    // Billing
    $table->string('invoice_type')->nullable();
    $table->string('invoice_frequency')->nullable();
    $table->decimal('invoice_amount', 10, 2)->nullable();
    $table->string('payment_status')->nullable();
    $table->date('payment_date')->nullable();
    $table->string('transaction_reference')->nullable();

    // Support
    $table->string('poc_name')->nullable();
    $table->string('poc_email')->nullable();
    $table->string('poc_contact')->nullable();
    $table->string('support_sla')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
