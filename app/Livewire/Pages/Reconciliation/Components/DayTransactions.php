<?php

namespace App\Livewire\Pages\Reconciliation\Components;

use App\Models\Reconciliation;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class DayTransactions extends Component
{
    public $data = [];

    #[On('mark_reconciliation_done')]
    public function markReconciliationDone() {
        
        $this->getData();
        foreach($this->data as $dt) {
            Reconciliation::create([
                'date'=> now(),
                'invoiceno' => $dt->invoiceno,
                'amount' => $dt->amount,
                'paymode' => $dt->paymode,
                'user_id' => auth()->user()->id
            ]);
        }

        $this->dispatch('reconciled');
    }

    #[On('data_imported')]
    public function getData() {
        $data = Transaction::join('sales', 'sales.invoiceno', 'transactions.invoiceno')
            ->join('clients', 'clients.id', 'sales.client_id')
            ->where('sales.selling_type', 'cash')
            ->select('transactions.date', 'clients.name', 'transactions.invoiceno', 'paymode', DB::raw('SUM(transactions.amount) as amount'))
            ->groupBy('transactions.date', 'clients.name', 'transactions.invoiceno', 'paymode')
            ->where(DB::raw("(DATE_FORMAT(transactions.created_at,'%Y-%m-%d'))"), now()->format('Y-m-d'))->get();

        $this->data = $data;
    }

    public function mount() {
        $this->getData();
    }

    public function render()
    {
        return view('livewire.pages.reconciliation.components.day-transactions');
    }
}
