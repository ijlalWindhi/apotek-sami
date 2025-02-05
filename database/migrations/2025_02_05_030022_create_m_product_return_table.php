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
        Schema::create('m_product_return', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('return_id')->constrained('m_return')->onDelete('cascade');
            $table->foreignId('product_transaction_id')->constrained('m_product_transaction')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('m_product')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('m_unit')->onDelete('cascade');
            $table->integer('qty_return')->default(0)->check('qty_return >= 0');
            $table->decimal('subtotal_return', 12, 2);

            $table->index(['return_id', 'product_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_product_return');
    }
};
