<?php

namespace App\Livewire\Pages\Reconciliation\Credit\Components;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CreditSale extends Component
{
    
    #[On('credit_reconciled')]
    public function render()
    {
        $data = Sale::doesntHave('reconciliation')->join('sale_items', 'sale_items.sale_id', 'sales.id')
            ->join('clients', 'clients.id', 'sales.client_id')
            ->where('sales.selling_type', 'credit')
            ->select('date', 'clients.name', 'invoiceno', DB::raw('SUM(sale_items.price) as amount'))
            ->groupBy('date', 'clients.name', 'invoiceno')
            ->get();

        return view('livewire.pages.reconciliation.credit.components.credit-sale', compact('data'));
    }
}
