<?php

namespace App\Livewire\Pages\Report\Payment;

use App\Models\Sale;
use Livewire\Component;

class PaymentsReport extends Component
{
    public $search = '';
    // public $data = [];

    public $filter = 'all';
    public function updatedSearch()
    {
        $this->render();
    }


    public function render()
    {
        $data = Sale::search($this->search)
        ->join('clients', 'sales.client_id', 'clients.id')
        ->join('payments', 'sales.invoiceno', 'payments.invoiceno')
        ->select('clients.name as client', 'clients.phone', 'payments.*')
        ->when($this->filter != 'all', function($qs) {
            return $qs->where('paymode', $this->filter);
        })
        ->get()->groupBy('invoiceno');
        return view('livewire.pages.report.payment.payments-report', compact('data'));
    }
}
