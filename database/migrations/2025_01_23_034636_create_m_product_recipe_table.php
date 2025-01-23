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
        Schema::create('m_product_recipe', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('recipe_id')->constrained('m_recipe')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('m_product')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('m_unit')->onDelete('cascade');
            $table->integer('qty')->default(0)->check('qty >= 0');
            $table->decimal('price', 12, 2)->check('price > 0');
            $table->decimal('tuslah', 12, 2);
            $table->decimal('discount', 12, 2)->default(0)->check('discount >= 0');
            $table->enum('discount_type', ['Percentage', 'Nominal'])->default('Percentage');
            $table->decimal('subtotal', 12, 2);
            $table->index(['recipe_id', 'product_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_product_recipe');
    }
};
