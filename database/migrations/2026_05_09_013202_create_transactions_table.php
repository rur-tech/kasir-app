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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
    ->nullable()
    ->constrained()
    ->nullOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();

            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();

            $table->foreignId('discount_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('subtotal')->default(0);

            $table->integer('discount_total')->default(0);

            $table->integer('grand_total')->default(0);

            $table->integer('cash')->default(0);

            $table->integer('change')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
