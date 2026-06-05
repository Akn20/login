<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('organization_id');

            $table->uuid('plan_id');

            $table->date('start_date');

            $table->date('expiry_date');

            $table->enum('status', [
                'trial',
                'active',
                'grace',
                'suspended',
                'expired'
            ])->default('trial');

            $table->boolean('auto_renew')->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};