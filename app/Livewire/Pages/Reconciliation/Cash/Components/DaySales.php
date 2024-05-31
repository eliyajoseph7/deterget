<?php

namespace App\Livewire\Pages\Reconciliation\Cash\Components;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DaySales extends Component
{
    public function render()
    {
        $data = Sale::doesntHave('reconciliation')->where(DB::raw("(DATE_FORMAT(sales.created_at,'%Y-%m-%d'))"), now()->format('Y-m-d'))
            ->join('sale_items', 'sale_items.sale_id', 'sales.id')
            ->join('clients', 'clients.id', 'sales.client_id')
            ->where('sales.selling_type', 'cash')
            ->select('date', 'clients.name', 'invoiceno', DB::raw('SUM(sale_items.price) as amount'))
            ->groupBy('date', 'clients.name', 'invoiceno')
            ->get();
        return view('livewire.pages.reconciliation.cash.components.day-sales', compact('data'));
    }
}
