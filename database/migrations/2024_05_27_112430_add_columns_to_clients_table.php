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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('tin_number')->after('phone');
            $table->string('vr_number')->after('tin_number')->nullable();
            $table->string('bank_account')->after('vr_number')->nullable();
            $table->string('bank_name')->after('bank_account')->nullable();
            $table->string('address')->after('bank_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('tin_number');
            $table->dropColumn('vr_number');
            $table->dropColumn('bank_account');
            $table->dropColumn('bank_name');
            $table->dropColumn('address');
        });
    }
};
