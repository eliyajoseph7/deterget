<?php

namespace App\Livewire\Pages\Reconciliation\Credit;

use App\Models\Payment;
use App\Models\Reconciliation;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CreditReconciliation extends Component
{
    public $reconciled = false;
    public $loading = false;

    #[On('credit_reconciled')]
    public function reconciled() {
        $this->reconciled = true;
        $this->loading = false;
        $this->dispatch('show_success', 'Reconciled successfully');
        $this->render();
    }

    #[On('mark_reconciliation')]
    public function markDone($total_sale, $total_transaction) {
        $this->loading = true;
        if($total_sale != $total_transaction) {
            $this->loading = false;
            $this->dispatch('show_error', 'Transactions does not balance!');
        } else {
            $this->dispatch('mark_reconciliation_done');
        }
    }

    #[On('delete_transaction')]
    public function delete($invoiceno) {
        // dd($invoiceno);
        Transaction::where('invoiceno', $invoiceno)->delete();
        Payment::where('invoiceno', $invoiceno)->delete();
        $this->dispatch('show_success', 'Deleted successfully');
        $this->dispatch('data_imported');
    }

    public function mount() {
        $check = Reconciliation::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), now()->format('Y-m-d'));
        if($check->exists()) {
            $this->reconciled = true;
        }
    }

    public function render()
    {
        return view('livewire.pages.reconciliation.credit.credit-reconciliation');
    }
}
