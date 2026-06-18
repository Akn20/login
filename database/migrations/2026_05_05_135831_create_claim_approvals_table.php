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
        Schema::create('claim_approvals', function (Blueprint $table) {
    $table->id();
    $table->uuid('claim_id');
    $table->decimal('approved_amount', 10, 2);
    $table->date('approval_date');
    $table->timestamps();
 

    $table->foreign('claim_id')->references('id')->on('insurance_claims')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_approvals');
    }
};
