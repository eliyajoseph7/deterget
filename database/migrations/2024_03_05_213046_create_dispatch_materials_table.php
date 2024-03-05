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
        Schema::create('dispatch_materials', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(today());
            $table->foreignId('raw_material_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->mediumText('purpose')->default(1);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatch_materials');
    }
};
