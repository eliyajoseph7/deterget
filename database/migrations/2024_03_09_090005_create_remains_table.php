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
        Schema::create('remains', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(today());
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->foreignId('warehouse_tnx_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remains');
    }
};
