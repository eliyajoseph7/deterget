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
        Schema::create('warehouse_tnxes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->string('action');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_tnxes');
    }
};
