<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('code')->unique()->nullable();

            $table->enum('category', [
                'Medicine',
                'Equipment',
                'Consumable'
            ]);

            $table->string('unit')->nullable();

            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);

            $table->integer('reorder_level')->default(0);
            $table->integer('current_stock')->default(0);

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->integer('stock')->default(0);
            
            $table->softDeletes(); // for trash
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};