<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('classification_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // insert 
        DB::table('permissions')->insert(
            array(
                array('name' => 'Add FG', 'slug' => 'add-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-23 20:07:04', 'updated_at' => '2024-02-24 06:39:58'),
                array('name' => 'Update FG', 'slug' => 'update-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:15', 'updated_at' => '2024-02-24 06:40:15'),
                array('name' => 'Delete FG', 'slug' => 'delete-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:45', 'updated_at' => '2024-02-24 06:40:45'),
                array('name' => 'View FG', 'slug' => 'view-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:59', 'updated_at' => '2024-02-24 06:40:59'),
                array('name' => 'Add RM', 'slug' => 'add-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:50:54', 'updated_at' => '2024-02-24 07:50:54'),
                array('name' => 'Update RM', 'slug' => 'update-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:09', 'updated_at' => '2024-02-24 07:51:09'),
                array('name' => 'Delete RM', 'slug' => 'delete-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:22', 'updated_at' => '2024-02-24 07:51:22'),
                array('name' => 'View RM', 'slug' => 'view-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:36', 'updated_at' => '2024-02-24 07:51:36'),
                array('name' => 'Add Product in Warehouse', 'slug' => 'add-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:17', 'updated_at' => '2024-02-24 07:53:17'),
                array('name' => 'Update Product in Warehouse', 'slug' => 'update-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:32', 'updated_at' => '2024-02-24 07:53:32'),
                array('name' => 'Delete Product in Warehouse', 'slug' => 'delete-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:47', 'updated_at' => '2024-02-24 07:53:47'),
                array('name' => 'View Product in Warehouse', 'slug' => 'view-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:03', 'updated_at' => '2024-02-24 07:54:03'),
                array('name' => 'Dispatch Product', 'slug' => 'dispatch-product', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:39', 'updated_at' => '2024-02-24 07:54:39'),
                array('name' => 'Update Dispached Product', 'slug' => 'update-dispached-product', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:58', 'updated_at' => '2024-02-24 07:54:58'),
                array('name' => 'Delete Dispatch Record', 'slug' => 'delete-dispatch-record', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:55:24', 'updated_at' => '2024-02-24 07:55:24'),
                array('name' => 'View Dispatched Products', 'slug' => 'view-dispatched-products', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:55:43', 'updated_at' => '2024-02-24 07:55:43'),
                array('name' => 'Add Unit of Measure', 'slug' => 'add-unit-of-measure', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:09', 'updated_at' => '2024-02-24 07:56:09'),
                array('name' => 'Update Unit of Measure', 'slug' => 'update-unit-of-measure', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:28', 'updated_at' => '2024-02-24 07:56:28'),
                array('name' => 'Delete Unit of Measure', 'slug' => 'delete-unit-of-measure', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:41', 'updated_at' => '2024-02-24 07:56:41'),
                array('name' => 'View Unit of Measures', 'slug' => 'view-unit-of-measures', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:02', 'updated_at' => '2024-02-24 07:57:02'),
                array('name' => 'Add Raw Material', 'slug' => 'add-raw-material', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:09', 'updated_at' => '2024-02-24 07:56:09'),
                array('name' => 'Update Raw Material', 'slug' => 'update-raw-material', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:28', 'updated_at' => '2024-02-24 07:56:28'),
                array('name' => 'Delete Raw Material', 'slug' => 'delete-raw-material', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:41', 'updated_at' => '2024-02-24 07:56:41'),
                array('name' => 'View Raw Materials', 'slug' => 'view-raw-materials', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:02', 'updated_at' => '2024-02-24 07:57:02'),
                array('name' => 'Add Product Category', 'slug' => 'add-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:09', 'updated_at' => '2024-02-24 07:56:09'),
                array('name' => 'Update Product Category', 'slug' => 'update-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:28', 'updated_at' => '2024-02-24 07:56:28'),
                array('name' => 'Delete Product Category', 'slug' => 'delete-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:41', 'updated_at' => '2024-02-24 07:56:41'),
                array('name' => 'View Product Categories', 'slug' => 'view-product-categories', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:02', 'updated_at' => '2024-02-24 07:57:02'),
                array('name' => 'Add Product', 'slug' => 'add-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:33', 'updated_at' => '2024-02-24 07:57:57'),
                array('name' => 'Update Product', 'slug' => 'update-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:46', 'updated_at' => '2024-02-24 07:57:46'),
                array('name' => 'Delete Product', 'slug' => 'delete-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:15', 'updated_at' => '2024-02-24 07:58:15'),
                array('name' => 'View Products', 'slug' => 'view-products', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:33', 'updated_at' => '2024-02-24 07:58:33'),
                array('name' => 'Add Permission', 'slug' => 'add-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:58', 'updated_at' => '2024-02-24 07:58:58'),
                array('name' => 'Update Permission', 'slug' => 'update-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:59:10', 'updated_at' => '2024-02-24 07:59:10'),
                array('name' => 'Delete Permission', 'slug' => 'delete-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:59:26', 'updated_at' => '2024-02-24 07:59:26'),
                array('name' => 'View Permissions', 'slug' => 'view-permissions', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:12', 'updated_at' => '2024-02-24 08:00:12'),
                array('name' => 'Add Role', 'slug' => 'add-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:28', 'updated_at' => '2024-02-24 08:00:28'),
                array('name' => 'Update Role', 'slug' => 'update-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:43', 'updated_at' => '2024-02-24 08:00:43'),
                array('name' => 'Delete Role', 'slug' => 'delete-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:56', 'updated_at' => '2024-02-24 08:00:56'),
                array('name' => 'View Roles', 'slug' => 'view-roles', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:01:11', 'updated_at' => '2024-02-24 08:01:11'),
                array('name' => 'Assign Permission to Role', 'slug' => 'assign-permission-to-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:01:47', 'updated_at' => '2024-02-24 08:01:47'),
                array('name' => 'Add User', 'slug' => 'add-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:01', 'updated_at' => '2024-02-24 08:02:01'),
                array('name' => 'Update User', 'slug' => 'update-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:13', 'updated_at' => '2024-02-24 08:02:13'),
                array('name' => 'Delete User', 'slug' => 'delete-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:24', 'updated_at' => '2024-02-24 08:02:24'),
                array('name' => 'View Users', 'slug' => 'view-users', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:51', 'updated_at' => '2024-02-24 08:02:51')
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
