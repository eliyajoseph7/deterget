<?php

use App\Livewire\Pages\Dashboard\Dashboard;
use App\Livewire\Pages\Setting\Permission\Permissions;
use App\Livewire\Pages\Setting\Product\Products;
use App\Livewire\Pages\Setting\ProductCategory\ProductCategories;
use App\Livewire\Pages\Setting\Role\Roles;
use App\Livewire\Pages\Setting\User\Users;
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
    return redirect('dashboard');
});

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::middleware('auth')->group(function() {
    // product categories
    Route::prefix('product-categories')->group(function() {
        Route::get('', ProductCategories::class)->name('categories');
    });
    // products
    Route::prefix('products')->group(function() {
        Route::get('', Products::class)->name('products');
    });

    // permissions
    Route::prefix('permissions')->group(function() {
        Route::get('', Permissions::class)->name('permissions');
    });

    // roles
    Route::prefix('roles')->group(function() {
        Route::get('', Roles::class)->name('roles');
    });

    // users
    Route::prefix('users')->group(function() {
        Route::get('', Users::class)->name('users');
    });
});

require __DIR__.'/auth.php';
