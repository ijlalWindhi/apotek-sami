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
        Schema::create('m_purchase_order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('code', 50)->unique();
            $table->foreignId('supplier_id')->constrained('m_supplier')->onDelete('cascade');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->date('payment_due_date');
            $table->foreignId('tax_id')->constrained('m_tax')->onDelete('cascade');
            $table->string('no_factur_supplier', 100)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('payment_type_id')->constrained('m_payment_type')->onDelete('cascade');
            $table->enum('payment_term', ['Tunai', '1 Hari', '7 Hari', '14 Hari', '21 Hari', '30 Hari', '45 Hari']);
            $table->boolean('payment_include_tax')->default(false);
            $table->integer('qty_total')->default(0);
            $table->decimal('discount', 12, 2);
            $table->enum('discount_type', ['Percentage', 'Nominal'])->default('Percentage');
            $table->decimal('nominal_discount', 12, 2);
            $table->decimal('total_before_tax_discount', 12, 2);
            $table->decimal('tax_total', 12, 2);
            $table->decimal('discount_total', 12, 2);
            $table->decimal('total', 12, 2);
            $table->index(['supplier_id', 'order_date', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_purchase_order');
    }
};
