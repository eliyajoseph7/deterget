<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SalesFormMultiple extends Component
{
    public $action = 'add';
    public $id;
    public $items = [];


    #[Rule('required', as: 'Seller')]
    public $seller_id;
    #[Rule('required', as: 'Selling type')]
    public $selling_type;

    #[Rule('required', as: 'Client')]
    public $client_id;
    public $credit_days;

    protected $listeners = [
        'update_sale_distribution' => 'editSale'
    ];

    // #[On('set_sale_product_id')]
    // public function setSaleProductId($id)
    // {
    //     $this->product_id = $id;
    // }

    // #[On('set_seller_id')]
    // public function setSellerId($id)
    // {
    //     $this->seller_id = $id;
    // }

    // #[On('set_client_id')]
    // public function setClientId($id)
    // {
    //     $this->client_id = $id;
    // }

    public function addField()
    {

        $this->validate([
            'items.*.*' => ['required'],
        ], [
            'items.*.*.required' => 'This field is required.',
        ]);

        $this->items[] = [
            'product_id' => null,
            'quantity' => []
        ];
    }
    public function removeField($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reset array keys
    }

    public function addSale()
    {
        $this->validate();
        $this->validate([
            'items.*.*' => ['required'],
        ], [
            'items.*.*.required' => 'This field is required.',
        ]);

        if ($this->selling_type == 'credit') {
            $this->validate([
                'credit_days' => 'required'
            ]);
        }

        $sale = new Sale;
        // $sale->date = $this->date;
        $sale->selling_type = $this->selling_type;
        $sale->credit_days = $this->credit_days;
        $sale->client_id = $this->client_id;
        $sale->seller_id = $this->seller_id;
        $sale->user_id = auth()->user()->id;
        $sale->invoiceno = $this->generateInvoiceNo();

        $sale->save();

        // sales items
        foreach ($this->items as $key => $item) {
            $product = Product::find($item['product_id']);
            $item['price'] = $item['quantity'] * $product->selling_price;
            $item['sale_id'] = $sale->id;

            SaleItem::create($item);
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Record saved successfully!',
        ]);

        return redirect()->route('distributions');
    }

    public function updateSale()
    {
        $this->validate();
        $this->validate([
            'items.*.*' => ['required'],
        ], [
            'items.*.*.required' => 'This field is required.',
        ]);

        if ($this->selling_type == 'credit') {
            $this->validate([
                'credit_days' => 'required'
            ]);
        }

        $sale = Sale::find($this->id);
        // $sale->date = $this->date;
        $sale->selling_type = $this->selling_type;
        $sale->credit_days = $this->credit_days;
        $sale->client_id = $this->client_id;
        $sale->seller_id = $this->seller_id;

        $sale->save();

        SaleItem::where('sale_id', $this->id)?->delete();
        // sales items
        foreach ($this->items as $key => $item) {
            $product = Product::find($item['product_id']);
            $item['price'] = $item['quantity'] * $product->selling_price;
            $item['sale_id'] = $sale->id;

            SaleItem::create($item);
        }

        $this->reset();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Record updated successfully!',
        ]);

        return redirect()->route('distributions');
    }

    public function generateInvoiceNo($count = 1)
    {
        $invoiceno = str_pad($count, 4, '0', STR_PAD_LEFT); // Generates a random 4-digit number


    //     $prev = Sale::where('invoiceno', $invoiceno)->where('client_id', $this->client_id)
    //     ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), '=', now()->format('Y-m-d'))->first();
    // if (!$prev) {
            $check = Sale::where('invoiceno', $invoiceno);
            if ($check->exists()) {
                // Log::error($invoiceno);
                $count = $count + 1;
                return $this->generateInvoiceNo($count);
            }
        // }


        return $invoiceno;
    }

    public function mount($saleId = null)
    {
        if ($saleId) {
            $this->action = 'update';
            $this->id = $saleId;

            $item = Sale::with(['items'])->find($saleId);
            $this->selling_type = $item->selling_type;
            $this->client_id = $item->client_id;
            $this->credit_days = $item->credit_days;
            $this->seller_id = $item->seller_id;

            $this->dispatch('set_seller_select_field', $item->seller_id);
            $this->dispatch('set_client_select_field', $item->client_id);
            foreach ($item->items as $index => $value) {
                $this->items[] = [
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity
                ];

                $this->dispatch('set_product_field', [$index, $value->product_id]);
            }
        } else {
            $this->items[] = [
                'product_id' => null,
                'quantity' => null
            ];
        }
    }

    public function render()
    {
        $products = Product::all();
        $users = User::whereHas('roles', function ($qs) {
            $qs->where('slug', 'product-distributor');
        })->get();
        $clients = Client::all();
        return view('livewire.pages.sale.components.sales.sales-form-multiple', compact('users', 'products', 'clients'));
    }
}
