<?php

namespace App\Livewire\Pages\Sale;

use App\Models\Client;
use App\Models\Sale;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Invoice extends Component
{
    public $sale;
    public $data = [];

    public $subtotal = 0;
    public $vat = 0;
    public $total = 0;

    public function mount($id) {
        $this->sale = Sale::with(['items'])->find($id);

        foreach($this->sale->items as $sl) {
            $this->subtotal += $sl->quantity * $sl->product->selling_price;
        }
        $this->vat = 0.18 * $this->subtotal;
        $this->total = $this->subtotal + $this->vat;
    }

    public function render()
    {
        return view('livewire.pages.sale.invoice');
    }
}
