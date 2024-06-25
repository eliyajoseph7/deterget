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
        // products report
        Schema::table('product_reports', function (Blueprint $table) {
            $table->double('pieces')->after('product_id')->default(1);
        });
        // warehouse reports
        Schema::table('warehouse_reports', function (Blueprint $table) {
            $table->double('pieces')->after('product_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // products report
        Schema::table('product_reports', function (Blueprint $table) {
            $table->dropColumn('pieces');
        });
        // warehouse reports
        Schema::table('warehouse_reports', function (Blueprint $table) {
            $table->dropColumn('pieces');
        });
    }

    
};
