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
    }

    #[On('mark_reconciliation_done')]
    public function markDone() {
        $this->loading = true;
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
