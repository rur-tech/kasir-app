<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        Schema::create('bundles', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('product_name')
                ->nullable();

            $table->bigInteger('bundle_price')
                ->default(0);

            $table->integer('stock')
                ->default(0);

            $table->text('description')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};