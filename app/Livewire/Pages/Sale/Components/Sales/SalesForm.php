<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Models\Client;
use App\Models\DispatchProduct;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\WarehouseDispatch;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class SalesForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $quantity;
    // #[Rule('required')]
    // public $date;

    #[Rule('required', as: 'Product')]
    public $product_id;

    #[Rule('required', as: 'Seller')]
    public $seller_id;
    #[Rule('required', as: 'Selling type')]
    public $selling_type;

    public $client_id;
    // public $client_phone;
    public $credit_days;

    protected $listeners = [
        'update_sale_distribution' => 'editSale'
    ];

    #[On('set_sale_product_id')]
    public function setSaleProductId($id)
    {
        $this->product_id = $id;
    }

    #[On('set_seller_id')]
    public function setSellerId($id)
    {
        $this->seller_id = $id;
    }

    #[On('set_client_id')]
    public function setClientId($id)
    {
        $this->client_id = $id;
    }

    public function addSale()
    {
        $this->validate();
        if($this->selling_type == 'credit') {
            $this->validate([
                'credit_days' => 'required'
            ]);
        }

        // $dispatched = WarehouseDispatch::where('product_id', $this->product_id)->where('assigned', $this->seller_id)
        //     ->where('date', now()->format('Y-m-d'))->sum('quantity');
            

        // if ($dispatched > 0) {
        //     if ($dispatched > $this->quantity) {
        //         $dispatch_product = new DispatchProduct;
        //         // $dispatch_product->date = $this->date;
        //         $dispatch_product->quantity = $dispatched - $this->quantity;
        //         $dispatch_product->product_id = $this->product_id;
        //         $dispatch_product->user_id = auth()->user()->id;

        //         $dispatch_product->save();
        //     }

        // }
        $product = Product::find($this->product_id);
        $sale_distribution = new Sale;
        // $sale_distribution->date = $this->date;
        $sale_distribution->quantity = $this->quantity;
        $sale_distribution->price = $this->quantity * $product->selling_price;
        $sale_distribution->product_id = $this->product_id;
        $sale_distribution->selling_type = $this->selling_type;
        $sale_distribution->credit_days = $this->credit_days;
        $sale_distribution->client_id = $this->client_id;
        // $sale_distribution->client_phone = $this->client_phone;
        // $sale_distribution->dispatch_product_id = $dispatch_product->id ?? null;
        $sale_distribution->seller_id = $this->seller_id;
        $sale_distribution->user_id = auth()->user()->id;
        $sale_distribution->invoiceno = $this->generateInvoiceNo();

        $sale_distribution->save();


        $this->resetForm();
        $this->dispatch('sale_distribution_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editSale($id)
    {
        $this->action = 'update';
        $qs = Sale::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        // $this->date = $qs->date;
        $this->product_id = $qs->product_id;
        $this->seller_id = $qs->seller_id;
        $this->client_id = $qs->client_id;
        // $this->client_phone = $qs->client_phone;
        $this->selling_type = $qs->selling_type;
        $this->credit_days = $qs->credit_days;
        $this->dispatch('update_sale_product_id_field', $qs->product_id);
        $this->dispatch('update_seller_id_field', $qs->seller_id);
        $this->dispatch('update_client_id_field', $qs->client_id);
    }

    public function updateSale()
    {
        $this->validate();
        if($this->selling_type == 'credit') {
            $this->validate([
                'credit_days' => 'required'
            ]);
        }

        $qs = Sale::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;
        $qs->seller_id = $this->seller_id;
        $qs->client_id = $this->client_id;
        // $qs->client_phone = $this->client_phone;
        $qs->selling_type = $this->selling_type;
        $qs->credit_days = $this->credit_days;

        $qs->save();
        // $dispatched = WarehouseDispatch::where('product_id', $this->product_id)->where('assigned', $this->seller_id)
        //     ->where('date', $qs->date)->sum('quantity');

        //     if ($dispatched > 0) {
        //         if ($dispatched > $this->quantity) {
        //             $dispatch_product = DispatchProduct::find($qs->dispatch_product_id);
        //         if($dispatch_product) {
        //             $dispatch_product->quantity = $dispatched - $this->quantity;
        //             $dispatch_product->save();
        //         }
        //     }
        // }

        $this->resetForm();
        $this->dispatch('sale_distribution_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function generateInvoiceNo($count = 1) {
        $invoiceno = str_pad($count, 4, '0', STR_PAD_LEFT); // Generates a random 4-digit number


        $prev = Sale::where('invoiceno', $invoiceno)->where('client_id', $this->client_id)
        ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), '=', now()->format('Y-m-d'))->first();
        if(!$prev) {
            $check = Sale::where('invoiceno', $invoiceno);
            if($check->exists()) {
                return $this->generateInvoiceNo($count++);
            }
        }


        return $invoiceno;
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editSale($id);
        }

        $this->dispatch('initialize_scripts');
    }

    public function resetForm()
    {
        $this->dispatch('reset_sale_product_id');
        $this->dispatch('reset_seller_id');
        $this->dispatch('reset_client_id');
        $this->reset();
    }

    public function render()
    {
        $products = Product::all();
        $users = User::whereHas('roles', function ($qs) {
            $qs->where('slug', 'product-distributor');
        })->get();
        $clients = Client::all();
        return view('livewire.pages.sale.components.sales.sales-form', compact('users', 'products', 'clients'));
    }
}
