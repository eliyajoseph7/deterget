<?php

use App\Livewire\Pages\Dashboard\Dashboard;
use App\Livewire\Pages\Finishedproduct\Products as Finishedproducts;
use App\Livewire\Pages\Rawmaterial\RawMaterials;
use App\Livewire\Pages\Report\Fg\Fg;
use App\Livewire\Pages\Report\Rm\Rm;
use App\Livewire\Pages\Report\Sale\Sale;
use App\Livewire\Pages\Report\Warehouse\Warehouse;
use App\Livewire\Pages\Sale\Distributions;
use App\Livewire\Pages\Setting\Permission\Permissions;
use App\Livewire\Pages\Setting\Product\Products;
use App\Livewire\Pages\Setting\ProductCategory\ProductCategories;
use App\Livewire\Pages\Setting\Rawmaterial\SettingRawMaterials;
use App\Livewire\Pages\Setting\Role\RolePermissions;
use App\Livewire\Pages\Setting\Role\Roles;
use App\Livewire\Pages\Setting\Uom\Uoms;
use App\Livewire\Pages\Setting\User\Users;
use App\Livewire\Pages\Warehouse\Warehouses;
use App\Models\Sale as ModelsSale;
use App\Models\WarehouseDispatch;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    // $dispatched = WarehouseDispatch::select('product_id', DB::raw('SUM(quantity) as quantity'))->groupBy('product_id')
    //         ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), now()->format('Y-m-d'))->get();

    //         return $dispatched;
    return redirect('dashboard');
});

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::middleware('auth')->group(function() {

    Route::prefix('settings')->group(function() {
        // unit of measure
        Route::prefix('unit-of-measures')->group(function() {
            Route::get('', Uoms::class)->name('uoms');
        });
        // raw materials
        Route::prefix('raw-materials')->group(function() {
            Route::get('', SettingRawMaterials::class)->name('materials');
        });

        // product categories
        Route::prefix('product-categories')->group(function() {
            Route::get('', ProductCategories::class)->name('categories');
        });
        // products
        Route::prefix('products')->group(function() {
            Route::get('', Products::class)->name('products_setup');
        });
    
        // permissions
        Route::prefix('permissions')->group(function() {
            Route::get('', Permissions::class)->name('permissions');
        });
    
        // roles
        Route::prefix('roles')->group(function() {
            Route::get('', Roles::class)->name('roles');
            Route::get('role-permissions/{slug}', RolePermissions::class)->name('role_permissions');
        });
    
        // users
        Route::prefix('users')->group(function() {
            Route::get('', Users::class)->name('users');
        });
    });

    Route::get('raw-materials', RawMaterials::class)->name('raw_materials');
    Route::get('products', Finishedproducts::class)->name('products');
    Route::get('manage-warehouse', Warehouses::class)->name('warehouses');
    Route::get('product-distribution', Distributions::class)->name('distributions');

    // reports
    Route::prefix('reports')->group(function() {
        Route::get('raw-material', Rm::class)->name('rm_report');
        Route::get('finished-goods', Fg::class)->name('fg_report');
        Route::get('warehouse-transactions', Warehouse::class)->name('warehouse_report');
        Route::prefix('sales')->group(function() {
            Route::get('general', Sale::class)->name('sale_report');
        });
    });
});

Route::get('register', function() {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
