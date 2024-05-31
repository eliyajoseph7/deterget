<?php

namespace App\Livewire\Pages\Reconciliation;

use App\Models\Sale;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class AddTransaction extends ModalComponent
{
    #[Validate('required')]
    public $date;
    #[Validate('required')]
    public $amount;
    #[Validate('required')]
    public $invoiceno;

    public function addTransaction() {
        $this->validate();
    }

    public function mount()
    {
        $this->dispatch('initialize_scripts');
    }

    public function render()
    {
        $invoices = Sale::doesntHave('reconciliation')->select('invoiceno')->get();
        return view('livewire.pages.reconciliation.add-transaction', compact('invoices'));
    }
}
