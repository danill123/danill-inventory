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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->unsignedBigInteger('category_id'); // References categories.id
            $table->unsignedBigInteger('supplier_id'); // References suppliers.id
            $table->integer('quantity')->default(0); // Inventory count
            $table->decimal('price', 10, 2); // Price per unit
            $table->decimal('cost', 10, 2)->nullable(); // Optional cost per unit
            $table->text('description')->nullable(); // Product description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
