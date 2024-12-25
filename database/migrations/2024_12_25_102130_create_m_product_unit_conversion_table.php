<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_product_unit_conversion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key ke product
            $table->foreignId('product_id')->constrained('m_product')->onDelete('cascade')->unique();

            // Unit asal dan tujuan
            $table->foreignId('from_unit_id')->constrained('m_unit')->unique();
            $table->foreignId('to_unit_id')->constrained('m_unit')->unique();

            // Nilai konversi (misal: 1 box = 12 pcs)
            $table->decimal('from_value', 12, 2);
            $table->decimal('to_value', 12, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_product_unit_conversion');
    }
};
