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
        Schema::create('m_recipe', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name');
            $table->integer('customer_age');
            $table->string('customer_address')->nullable();
            $table->string('doctor_name');
            $table->string('doctor_sip')->nullable();
            $table->index(['staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_recipe');
    }
};
