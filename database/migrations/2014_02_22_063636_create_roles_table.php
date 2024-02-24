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
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        
        // insert initial data

        DB::table('roles')->insert(
            [
                [
                    'name' => 'Super Admin',
                    'slug' => 'super-admin'
                ],
                [
                    'name' => 'Raw Material Manager',
                    'slug' => 'raw-material-manager'
                ],
                [
                    'name' => 'Product Record Manager',
                    'slug' => 'product-record-manager'
                ],
                [
                    'name' => 'Warehouse Manager',
                    'slug' => 'warehouse-manager'
                ],
                [
                    'name' => 'Product Distributor',
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
