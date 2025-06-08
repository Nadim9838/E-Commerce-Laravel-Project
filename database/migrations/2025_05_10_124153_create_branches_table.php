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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_code', 100)->unique();
            $table->string('name');
            $table->string('number', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('login_id', 100)->nullable();
            $table->string('password');
            $table->string('branch_logo')->nullable();
            $table->text('address')->nullable();
            $table->string('gst_no', 100)->nullable();
            $table->string('support_number', 20)->nullable();
            $table->string('support_email')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
