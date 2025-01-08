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
        Schema::create('m_product_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('purchase_order')->constrained('m_purchase_order');
            $table->foreignId('product')->constrained('m_product');
            $table->integer('qty')->default(0)->check('qty >= 0');
            $table->decimal('price', 12, 2)->check('price > 0');
            $table->decimal('discount', 12, 2)->default(0)->check('discount >= 0');
            $table->enum('discount_type', ['Percentage', 'Nominal'])->default('Percentage');
            $table->decimal('subtotal', 12, 2);
            $table->text('description')->nullable();
            $table->index(['purchase_order', 'product']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_product_purchase_order');
    }
};
