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
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->foreignId('raw_material_id')->nullable()->constrained()->nullOnDelete();
            $table->double('quantity')->default(1);
            $table->mediumText('purpose');
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
        Schema::dropIfExists('dispatch_materials');
    }
};
