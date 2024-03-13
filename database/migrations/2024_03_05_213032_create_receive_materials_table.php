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
        Schema::create('receive_materials', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->foreignId('raw_material_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->string('invoice')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('material_tnx_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_materials');
    }
};
