<?php

namespace App\Livewire\Pages\Reconciliation\Debit;

use App\Models\Sale;
use Livewire\Component;

class Debtors extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->render();
    }

    public function render()
    {
        $data = Sale::search($this->search)->doesntHave('reconciliation')->with('transactions')
        ->join('clients', 'sales.client_id', 'clients.id')
        ->select('clients.name as client', 'clients.phone', 'sales.*')->get()
        ->groupBy('client');
        return view('livewire.pages.reconciliation.debit.debtors', compact('data'));
    }
}
