<?php

namespace App\Livewire\Pages\Dashboard;

use App\Helpers\Helper;
use App\Models\DispatchMaterial;
use App\Models\DispatchProduct;
use App\Models\ReceiveMaterial;
use App\Models\ReceiveProduct;
use App\Models\Sale;
use App\Models\WarehouseTnx;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount() {
        if(!Helper::has_role('super-user')) {
            if(Helper::has_permission('view-rm')) {
                return redirect()->route('raw_materials');
            } else if(Helper::has_permission('view-fg')) {
                return redirect()->route('products');
            } else if(Helper::has_permission('view-product-in-warehouse')) {
                return redirect()->route('warehouses');
            } else if(Helper::has_permission('view-product-distributions')) {
                return redirect()->route('distributions');
            } else {
                return redirect()->route('profile');
            }
        }
    }
    public function render()
    {
        $totalSale = Sale::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), now()->format('Y-m-d'))->sum('price');
        $receivedMat = ReceiveMaterial::where('date', '>=', now()->subDays(7))->count();
        $dispatchedMat = DispatchMaterial::where('date', '>=', now()->subDays(7))->count();
        $receivedProd = ReceiveProduct::where('date', '>=', now()->subDays(7))->count();
        $dispatchedProd = DispatchProduct::where('date', '>=', now()->subDays(7))->count();

        $outofstock = WarehouseTnx::join('products', 'products.id', 'warehouse_tnxes.product_id')
        ->select('products.name as product', DB::raw('SUM(warehouse_tnxes.quantity) as remain'))
        ->groupBy('products.name')->orderBy('remain', 'ASC')->limit(2)->get();
        return view('livewire.pages.dashboard.dashboard', compact('totalSale', 'receivedMat', 'dispatchedMat', 'receivedProd', 'dispatchedProd', 'outofstock'));
    }
}
