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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            // $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            // $table->double('quantity')->default(1);
            // $table->string('client_name')->nullable();
            // $table->string('client_phone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->String('seller_id')->nullable();
            $table->enum('selling_type', ['cash', 'credit'])->default('cash');
            $table->String('credit_days')->nullable();
            $table->foreignId('dispatch_product_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
