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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('slug');
            $table->timestamps();
        });
        
        // insert initial data

        DB::table('roles')->insert(
            [
                [
                    'role' => 'Super Admin',
                    'slug' => 'super-admin'
                ],
                [
                    'role' => 'Raw Material Manager',
                    'slug' => 'raw-material-manager'
                ],
                [
                    'role' => 'Product Record Manager',
                    'slug' => 'product-record-manager'
                ],
                [
                    'role' => 'Warehouse Manager',
                    'slug' => 'warehouse-manager'
                ],
                [
                    'role' => 'Product Distributor',
                    'slug' => 'product-distributor'
                ]
            ],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
