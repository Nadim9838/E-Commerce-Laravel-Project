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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 100)->unique();
            $table->string('product_name');
            $table->string('product_brand')->nullable();
            $table->string('feature_photo')->nullable();
            $table->string('slug')->unique();
            $table->integer('stock');
            $table->string('sort_desc')->nullable();
            $table->text('detail_desc')->nullable();
            $table->double('price')->nullable();
            $table->double('discount_price')->nullable();
            $table->string('model_no')->nullable();
            $table->string('sku')->nullable();
            $table->integer('tax')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
