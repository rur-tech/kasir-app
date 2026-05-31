<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run Migration
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI CABANG
            |--------------------------------------------------------------------------
            */
            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | RELASI KATEGORI
            |--------------------------------------------------------------------------
            */
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | DATA PRODUK
            |--------------------------------------------------------------------------
            */

            // Nama produk
            $table->string('name');

            // Harga produk
            $table->integer('price')->default(0);

            // Stock produk
            $table->integer('stock')->default(0);

            // Deskripsi produk
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse Migration
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};