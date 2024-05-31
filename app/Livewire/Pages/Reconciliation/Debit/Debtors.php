<?php

namespace App\Livewire\Pages\Reconciliation\Debit;

use App\Models\Sale;
use Livewire\Component;

class Debtors extends Component
{
    public function render()
    {
        $data = Sale::doesntHave('reconciliation')->with('transactions')
        ->join('clients', 'sales.client_id', 'clients.id')
        ->select('clients.name as client', 'sales.*')->get()
        ->groupBy('client');
        return view('livewire.pages.reconciliation.debit.debtors', compact('data'));
    }
}
