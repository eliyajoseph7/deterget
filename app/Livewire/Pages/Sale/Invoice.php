<?php

namespace App\Livewire\Pages\Sale;

use App\Models\Client;
use App\Models\Sale;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Invoice extends Component
{
    public $client;
    public $date;
    public $invoiceno = '';
    public $data = [];

    public $subtotal = 0;
    public $vat = 0;
    public $total = 0;

    public function mount($clientId, $date) {
        $this->date = new DateTime($date);
        $this->client = Client::find($clientId);
        $sale = Sale::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), '=', $date)->where('client_id', $clientId)
        ->select('product_id', 'invoiceno', DB::raw('SUM(quantity) as quantity'))->with('product')
        ->groupBy('product_id', 'invoiceno')
        ->get();

        $this->data = $sale;
        $this->invoiceno = $sale[0]->invoiceno;

        foreach($sale as $sl) {
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
