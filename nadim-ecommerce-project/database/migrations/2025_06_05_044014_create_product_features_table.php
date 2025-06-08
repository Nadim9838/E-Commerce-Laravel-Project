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
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('features')->nullable();
            $table->string('movement')->nullable();
            $table->string('calibre')->nullable();
            $table->string('series')->nullable();
            $table->string('case_size', 100)->nullable();
            $table->string('case_shape', 100)->nullable();
            $table->string('case_material')->nullable();
            $table->string('dial_color', 100)->nullable();
            $table->string('strap_type', 100)->nullable();
            $table->string('strap_color', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_features');
    }
};
