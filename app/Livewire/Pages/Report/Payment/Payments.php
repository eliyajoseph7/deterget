<?php

namespace App\Livewire\Pages\Report\Payment;

use App\Models\Sale;
use Livewire\Component;

class Payments extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->render();
    }

    public function render()
    {
        $data = Sale::search($this->search)
        ->join('clients', 'sales.client_id', 'clients.id')
        ->join('payments', 'sales.invoiceno', 'payments.invoiceno')
        ->select('clients.name as client', 'payments.*')->get()
        ->groupBy('invoiceno');
        // dd($data);
        return view('livewire.pages.report.payment.payments', compact('data'));
    }
}
