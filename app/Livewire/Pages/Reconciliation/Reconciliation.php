<?php

namespace App\Livewire\Pages\Reconciliation;

use App\Models\Reconciliation as ModelsReconciliation;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Reconciliation extends Component
{
    public $reconciled = false;
    public $loading = false;

    #[On('reconciled')]
    public function reconciled() {
        $this->reconciled = true;
        $this->loading = false;
        $this->dispatch('show_success', 'Reconciled successfully');
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

    public function mount() {
        $check = ModelsReconciliation::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), now()->format('Y-m-d'));
        if($check->exists()) {
            $this->reconciled = true;
        }
    }

    public function render()
    {
        return view('livewire.pages.reconciliation.reconciliation');
    }
}
