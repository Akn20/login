<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // UUID

            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();

            // institution_id must match institutions.id (UUID)
            $table->char('institution_id', 36);
            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('cascade');

            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
