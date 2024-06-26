<?php

use App\Http\Controllers\PaginateController;
use App\Livewire\Pages\Dashboard\Dashboard;
use App\Livewire\Pages\Finishedproduct\Products as Finishedproducts;
use App\Livewire\Pages\Rawmaterial\Components\Dispatch\MaterialDispatchMultiple;
use App\Livewire\Pages\Rawmaterial\Components\Receive\MaterialReceiveMultiple;
use App\Livewire\Pages\Rawmaterial\RawMaterials;
use App\Livewire\Pages\Reconciliation\Cash\Reconciliation as CashReconciliation;
use App\Livewire\Pages\Reconciliation\Credit\CreditReconciliation;
use App\Livewire\Pages\Reconciliation\Debit\Debtors;
use App\Livewire\Pages\Report\Fg\Fg;
use App\Livewire\Pages\Report\Fg\General as FgGeneral;
use App\Livewire\Pages\Report\Payment\Payments;
use App\Livewire\Pages\Report\Payment\PaymentsReport;
use App\Livewire\Pages\Report\Rm\General;
use App\Livewire\Pages\Report\Rm\Rm;
use App\Livewire\Pages\Report\Rm\RmMovement;
use App\Livewire\Pages\Report\Sale\Sale;
use App\Livewire\Pages\Report\Warehouse\General as WarehouseGeneral;
use App\Livewire\Pages\Report\Warehouse\Warehouse;
use App\Livewire\Pages\Sale\Components\Sales\SalesFormMultiple;
use App\Livewire\Pages\Sale\Distributions;
use App\Livewire\Pages\Sale\Invoice;
use App\Livewire\Pages\Setting\Client\ClientList;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::middleware('auth')->group(function () {

    Route::prefix('settings')->group(function () {
        // clients
        Route::prefix('clients')->group(function () {
            Route::get('', ClientList::class)->name('clients');
        });
        // unit of measure
        Route::prefix('unit-of-measures')->group(function () {
            Route::get('', Uoms::class)->name('uoms');
        });
        // raw materials
        Route::prefix('raw-materials')->group(function () {
            Route::get('', SettingRawMaterials::class)->name('materials');
        });

        // product categories
        Route::prefix('product-categories')->group(function () {
            Route::get('', ProductCategories::class)->name('categories');
        });
        // products
        Route::prefix('products')->group(function () {
            Route::get('', Products::class)->name('products_setup');
        });

        // permissions
        Route::prefix('permissions')->group(function () {
            Route::get('', Permissions::class)->name('permissions');
        });

        // roles
        Route::prefix('roles')->group(function () {
            Route::get('', Roles::class)->name('roles');
            Route::get('role-permissions/{slug}', RolePermissions::class)->name('role_permissions');
        });

        // users
        Route::prefix('users')->group(function () {
            Route::get('', Users::class)->name('users');
        });
    });

    Route::prefix('raw-materials')->group(function() {
        Route::get('', RawMaterials::class)->name('raw_materials');
        Route::get('receive-multiple', MaterialReceiveMultiple::class)->name('multiple_materials_receive');
        Route::get('dispatch-multiple', MaterialDispatchMultiple::class)->name('multiple_materials_dispatch');

    });
    Route::get('products', Finishedproducts::class)->name('products');
    Route::get('manage-warehouse', Warehouses::class)->name('warehouses');
    Route::prefix('product-distribution')->group(function() {
        Route::get('', Distributions::class)->name('distributions');
        Route::get('invoice/{id}', Invoice::class)->name('invoice');
        Route::get('sale-form', SalesFormMultiple::class)->name('add_sales');
        Route::get('sale-form/{saleId}', SalesFormMultiple::class)->name('edit_sales');
    });

    // reports
    Route::prefix('reports')->group(function () {
        Route::prefix('raw-material')->group(function() {
            Route::get('general', General::class)->name('rm_report');
            Route::get('general-by-date/{materialId}', Rm::class)->name('rm_report_by_date');
            Route::get('detailed/{material}/{date}', RmMovement::class)->name('rm_detailed_report');
        });
        Route::prefix('finished-goods')->group(function() {
            Route::get('general', FgGeneral::class)->name('fg_report');
            Route::get('general_by_date/{productId}', Fg::class)->name('fg_report_by_date');
        });
        Route::prefix('warehouse-transactions')->group(function() {
            Route::get('general', WarehouseGeneral::class)->name('warehouse_report');
            Route::get('general_by_date/{productId}', Warehouse::class)->name('warehouse_report_by_date');
        });
        Route::prefix('sales')->group(function () {
            Route::get('general', Sale::class)->name('sale_report');
        });
        Route::prefix('invoices')->group(function () {
            Route::get('payments', PaymentsReport::class)->name('payments');
        });
    });

    // reconciliation
    Route::prefix('reconciliation')->group(function() {
        Route::get('cash', CashReconciliation::class)->name('cash_reconciliation');
        Route::get('credit', CreditReconciliation::class)->name('credit_reconciliation');
        Route::get('debtors', Debtors::class)->name('debtors');
    });
});

Route::get('register', function () {
    return redirect()->route('login');
});

Route::get('logout', function () {
    
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();
    return redirect()->route('login');
})->name('logout');

require __DIR__ . '/auth.php';

// Route::get('test', function() {

//     $data = ModelsSale::join('clients', 'sales.client_id', 'clients.id')
//     ->join('payments', 'sales.invoiceno', 'payments.invoiceno')
//     ->select('clients.name as client', 'payments.*')->get()
//     ->groupBy('payments.invoiceno');

//     return $data;
// });

