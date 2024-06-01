<?php

namespace App\Livewire\Pages\Reconciliation;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Transaction;
use Livewire\Attributes\On;
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
    #[Validate('required')]
    public $paymode;

    #[On('set_invoiceno')]
    public function setInvoiceNo($invoiceno) {
        $this->invoiceno = $invoiceno;
    }

    public function addTransaction() {
        $this->validate();
        $qs = Transaction::where('invoiceno', $this->invoiceno)->first();
        $paid = Payment::where('invoiceno', $this->invoiceno)->sum('amount');
            $transDate = $qs?->date;
            if (!$qs) {
                $qs = Transaction::create([
                    'date' => $this->date,
                    'invoiceno' => $this->invoiceno,
                    'amount' => $this->amount,
                    'paymode' => $this->paymode,
                ]);
            } else {
                $qs->date = $this->date;
                $qs->invoiceno = $this->invoiceno;
                $qs->paymode = $this->paymode;
                // if($this->date == $transDate->format('Y-m-d')) {
                    $qs->amount = $paid + $this->amount;
                // } else {
                //     $qs->amount = $this->amount;
                // }
    
                $qs->save();
            }

            // insert into payments table for history purposes
            Payment::create([
                'date' => $this->date,
                'invoiceno' => $this->invoiceno,
                'amount' => $this->amount,
                'paymode' => $this->paymode,
                'user_id' => auth()->user()->id,
            ]);

            $this->reset();
            $this->closeModal();
            $this->dispatch('data_added');
            $this->dispatch('show_success', 'Transaction recorded successfully!');
    }

    public function mount()
    {
        $this->dispatch('initialize_scripts');
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $invoices = Sale::doesntHave('reconciliation')->distinct('invoiceno')->select('invoiceno', 'client_id')->with('client')->get();
        $paymodes = Sale::$paymodes;
        return view('livewire.pages.reconciliation.add-transaction', compact('invoices', 'paymodes'));
    }
}
