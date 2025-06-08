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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('number', 20);
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('password');
            $table->string('reward')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamp('last_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
