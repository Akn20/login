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
    Schema::create('receptionist_billing', function (Blueprint $table) {
        $table->uuid('id')->primary();   // ✅ UUID PK
        $table->string('receipt_no')->unique();

        $table->uuid('patient_id');      // ✅ UUID FK
        $table->uuid('visit_id')->nullable();

        $table->decimal('amount', 10, 2);
        $table->string('payment_mode')->default('CASH');

        $table->uuid('collected_by');    // user id UUID

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptionist_billing');
    }
};
