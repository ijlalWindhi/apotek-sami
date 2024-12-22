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
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->enum('type', ['Pedagang Besar Farmasi', 'Apotek Lain', 'Toko Obat', 'Lain-Lain']);
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->foreignId('payment_type')->constrained('m_payment_type');
            $table->enum('payment_term', ['Tunai', '1 Hari', '7 Hari', '14 Hari', '21 Hari', '30 Hari', '45 Hari']);
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone_1', 50)->nullable();
            $table->string('phone_2', 50)->nullable();
            $table->string('email', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_supplier');
    }
};
