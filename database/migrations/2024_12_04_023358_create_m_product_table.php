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
        Schema::create('m_product', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->enum('type', ['Obat', 'Alat Kesehatan', 'Umum', 'Lain-Lain']);
            $table->enum('drug_group', [
                'Obat Bebas',
                'Obat Bebas Terbatas',
                'Obat Keras',
                'Obat Golongan Narkotika',
                'Obat Fitofarmaka',
                'Obat Herbal Terstandar (OHT)',
                'Obat Herbal (Jamu)',
            ]);
            $table->string('sku')->unique();
            $table->integer('minimum_smallest_stock')->default(0);
            $table->decimal('smallest_stock', 12, 2)->default(0);
            $table->decimal('largest_stock', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('supplier_id')->constrained('m_supplier')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('largest_unit')->constrained('m_unit')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('smallest_unit')->constrained('m_unit')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('conversion_value')->default(1);
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('selling_price', 12, 2);
            $table->decimal('margin_percentage', 5, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_product');
    }
};
