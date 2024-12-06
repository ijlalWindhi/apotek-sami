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
            $table->boolean('status')->default(true); // true = dijual, false = tidak dijual
            $table->string('sku')->unique();
            $table->foreignId('unit_id')->constrained('m_unit');
            $table->foreignId('category_id')->constrained('m_category_product');
            $table->integer('minimum_stock')->default(0);
            $table->string('manufacturer')->nullable(); // pabrikan
            $table->text('notes')->nullable();
            $table->decimal('purchase_price', 12, 2); // harga beli
            $table->boolean('show_markup_margin')->default(false);
            $table->decimal('markup_percentage', 5, 2)->nullable();
            $table->decimal('margin_percentage', 5, 2)->nullable();
            $table->decimal('selling_price', 12, 2);
            $table->boolean('show_overhead_cost')->default(false);
            $table->decimal('overhead_cost_percentage', 5, 2)->nullable(); // Persentase biaya overhead
            $table->decimal('overhead_cost_value', 12, 2)->nullable(); // Nilai biaya overhead dalam rupiah
            $table->enum('overhead_cost_type', ['percentage', 'fixed'])->default('percentage'); // Tipe perhitungan tuslah
            $table->text('overhead_cost_description')->nullable(); // Keterangan detail biaya overhead
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
