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
        Schema::create('receive_products', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_tnx_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('visible', ['yes', 'no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_products');
    }
};
