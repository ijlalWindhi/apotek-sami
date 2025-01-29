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
        Schema::create('m_transaction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('customer_type', ['Umum', 'Rutin', 'Karyawan'])->default('Umum');
            $table->foreignId('recipe_id')->nullable()->constrained('m_recipe')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->foreignId('payment_type_id')->constrained('m_payment_type')->onDelete('cascade');
            $table->enum('status', ['Terbayar', 'Belum Lunas', 'Tertunda'])->default('Terbayar');
            $table->string('invoice_number')->unique();
            $table->decimal('discount', 12, 2)->default(0);
            $table->enum('discount_type', ['Percentage', 'Nominal'])->default('Percentage');
            $table->decimal('nominal_discount', 12, 2);
            $table->decimal('paid_amount', 12, 2);
            $table->decimal('change_amount', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('total_before_discount', 12, 2);
            $table->foreignId('created_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_transaction');
    }
};
