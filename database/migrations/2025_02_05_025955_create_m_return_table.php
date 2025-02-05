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
        Schema::create('m_return', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('return_number')->unique();
            $table->foreignId('transaction_id')->constrained('m_transaction')->onDelete('cascade');
            $table->text('return_reason')->nullable();
            $table->integer('qty_total')->default(0);
            $table->decimal('total_before_discount', 12, 2);
            $table->decimal('total_return', 12, 2);
            $table->foreignId('created_by')->constrained('users');

            $table->index(['transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_return');
    }
};
