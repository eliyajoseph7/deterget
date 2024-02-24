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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->timestamps();
        });

        // insert initial data

        DB::table('classifications')->insert(
            [
                [
                    'name' => 'Raw Materials',
                    'category' => 'main'
                ],
                [
                    'name' => 'Finished Goods',
                    'category' => 'main'
                ],
                [
                    'name' => 'Products Management',
                    'category' => 'main'
                ],
                [
                    'name' => 'Products Dispatch',
                    'category' => 'main'
                ],
                [
                    'name' => 'Product Categories',
                    'category' => 'settings'
                ],
                [
                    'name' => 'Products',
                    'category' => 'settings'
                ],
                [
                    'name' => 'Permissions',
                    'category' => 'settings'
                ],
                [
                    'name' => 'Roles',
                    'category' => 'settings'
                ],
                [
                    'name' => 'Users',
                    'category' => 'settings'
                ]
            ],
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifications');
    }
};
