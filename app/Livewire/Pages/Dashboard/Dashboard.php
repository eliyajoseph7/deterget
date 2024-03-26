<?php

namespace App\Livewire\Pages\Dashboard;

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
