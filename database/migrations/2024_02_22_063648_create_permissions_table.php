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
                array('id' => '1', 'name' => 'Add FG', 'slug' => 'add-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-23 20:07:04', 'updated_at' => '2024-02-24 06:39:58'),
                array('id' => '2', 'name' => 'Update FG', 'slug' => 'update-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:15', 'updated_at' => '2024-02-24 06:40:15'),
                array('id' => '3', 'name' => 'Delete FG', 'slug' => 'delete-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:45', 'updated_at' => '2024-02-24 06:40:45'),
                array('id' => '4', 'name' => 'View FG', 'slug' => 'view-fg', 'classification_id' => '2', 'user_id' => '1', 'created_at' => '2024-02-24 06:40:59', 'updated_at' => '2024-02-24 06:40:59'),
                array('id' => '5', 'name' => 'Add RM', 'slug' => 'add-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:50:54', 'updated_at' => '2024-02-24 07:50:54'),
                array('id' => '6', 'name' => 'Update RM', 'slug' => 'update-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:09', 'updated_at' => '2024-02-24 07:51:09'),
                array('id' => '7', 'name' => 'Delete RM', 'slug' => 'delete-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:22', 'updated_at' => '2024-02-24 07:51:22'),
                array('id' => '8', 'name' => 'View RM', 'slug' => 'view-rm', 'classification_id' => '1', 'user_id' => '1', 'created_at' => '2024-02-24 07:51:36', 'updated_at' => '2024-02-24 07:51:36'),
                array('id' => '9', 'name' => 'Add Product in Warehouse', 'slug' => 'add-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:17', 'updated_at' => '2024-02-24 07:53:17'),
                array('id' => '10', 'name' => 'Update Product in Warehouse', 'slug' => 'update-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:32', 'updated_at' => '2024-02-24 07:53:32'),
                array('id' => '11', 'name' => 'Delete Product in Warehouse', 'slug' => 'delete-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:53:47', 'updated_at' => '2024-02-24 07:53:47'),
                array('id' => '12', 'name' => 'View Product in Warehouse', 'slug' => 'view-product-in-warehouse', 'classification_id' => '3', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:03', 'updated_at' => '2024-02-24 07:54:03'),
                array('id' => '13', 'name' => 'Dispatch Product', 'slug' => 'dispatch-product', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:39', 'updated_at' => '2024-02-24 07:54:39'),
                array('id' => '14', 'name' => 'Update Dispached Product', 'slug' => 'update-dispached-product', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:54:58', 'updated_at' => '2024-02-24 07:54:58'),
                array('id' => '15', 'name' => 'Delete Dispatch Record', 'slug' => 'delete-dispatch-record', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:55:24', 'updated_at' => '2024-02-24 07:55:24'),
                array('id' => '16', 'name' => 'View Dispatched Products', 'slug' => 'view-dispatched-products', 'classification_id' => '4', 'user_id' => '1', 'created_at' => '2024-02-24 07:55:43', 'updated_at' => '2024-02-24 07:55:43'),
                array('id' => '17', 'name' => 'Add Product Category', 'slug' => 'add-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:09', 'updated_at' => '2024-02-24 07:56:09'),
                array('id' => '18', 'name' => 'Update Product Category', 'slug' => 'update-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:28', 'updated_at' => '2024-02-24 07:56:28'),
                array('id' => '19', 'name' => 'Delete Product Category', 'slug' => 'delete-product-category', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:56:41', 'updated_at' => '2024-02-24 07:56:41'),
                array('id' => '20', 'name' => 'View Product Categories', 'slug' => 'view-product-categories', 'classification_id' => '5', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:02', 'updated_at' => '2024-02-24 07:57:02'),
                array('id' => '21', 'name' => 'Add Product', 'slug' => 'add-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:33', 'updated_at' => '2024-02-24 07:57:57'),
                array('id' => '22', 'name' => 'Update Product', 'slug' => 'update-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:57:46', 'updated_at' => '2024-02-24 07:57:46'),
                array('id' => '23', 'name' => 'Delete Product', 'slug' => 'delete-product', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:15', 'updated_at' => '2024-02-24 07:58:15'),
                array('id' => '24', 'name' => 'View Products', 'slug' => 'view-products', 'classification_id' => '6', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:33', 'updated_at' => '2024-02-24 07:58:33'),
                array('id' => '25', 'name' => 'Add Permission', 'slug' => 'add-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:58:58', 'updated_at' => '2024-02-24 07:58:58'),
                array('id' => '26', 'name' => 'Update Permission', 'slug' => 'update-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:59:10', 'updated_at' => '2024-02-24 07:59:10'),
                array('id' => '27', 'name' => 'Delete Permission', 'slug' => 'delete-permission', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 07:59:26', 'updated_at' => '2024-02-24 07:59:26'),
                array('id' => '28', 'name' => 'View Permissions', 'slug' => 'view-permissions', 'classification_id' => '7', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:12', 'updated_at' => '2024-02-24 08:00:12'),
                array('id' => '29', 'name' => 'Add Role', 'slug' => 'add-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:28', 'updated_at' => '2024-02-24 08:00:28'),
                array('id' => '30', 'name' => 'Update Role', 'slug' => 'update-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:43', 'updated_at' => '2024-02-24 08:00:43'),
                array('id' => '31', 'name' => 'Delete Role', 'slug' => 'delete-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:00:56', 'updated_at' => '2024-02-24 08:00:56'),
                array('id' => '32', 'name' => 'View Roles', 'slug' => 'view-roles', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:01:11', 'updated_at' => '2024-02-24 08:01:11'),
                array('id' => '33', 'name' => 'Assign Permission to Role', 'slug' => 'assign-permission-to-role', 'classification_id' => '8', 'user_id' => '1', 'created_at' => '2024-02-24 08:01:47', 'updated_at' => '2024-02-24 08:01:47'),
                array('id' => '34', 'name' => 'Add User', 'slug' => 'add-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:01', 'updated_at' => '2024-02-24 08:02:01'),
                array('id' => '35', 'name' => 'Update User', 'slug' => 'update-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:13', 'updated_at' => '2024-02-24 08:02:13'),
                array('id' => '36', 'name' => 'Delete User', 'slug' => 'delete-user', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:24', 'updated_at' => '2024-02-24 08:02:24'),
                array('id' => '37', 'name' => 'View Users', 'slug' => 'view-users', 'classification_id' => '9', 'user_id' => '1', 'created_at' => '2024-02-24 08:02:51', 'updated_at' => '2024-02-24 08:02:51')
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
