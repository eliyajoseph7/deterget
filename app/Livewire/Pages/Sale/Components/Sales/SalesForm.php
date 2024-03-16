<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Models\DispatchProduct;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\WarehouseDispatch;
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

    public $client_name;
    public $client_phone;

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


    public function addSale()
    {
        $this->validate();

        $dispatched = WarehouseDispatch::where('product_id', $this->product_id)->where('assigned', $this->seller_id)
            ->where('date', now()->format('Y-m-d'))->sum('quantity');
            

        if ($dispatched > 0) {
            if ($dispatched > $this->quantity) {
                $dispatch_product = new DispatchProduct;
                // $dispatch_product->date = $this->date;
                $dispatch_product->quantity = $dispatched - $this->quantity;
                $dispatch_product->product_id = $this->product_id;
                $dispatch_product->user_id = auth()->user()->id;

                $dispatch_product->save();
            }

        }
        $sale_distribution = new Sale;
        // $sale_distribution->date = $this->date;
        $sale_distribution->quantity = $this->quantity;
        $sale_distribution->product_id = $this->product_id;
        $sale_distribution->client_name = $this->client_name;
        $sale_distribution->client_phone = $this->client_phone;
        $sale_distribution->dispatch_product_id = $dispatch_product->id ?? null;
        $sale_distribution->seller_id = $this->seller_id;
        $sale_distribution->user_id = auth()->user()->id;

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
        $this->client_name = $qs->client_name;
        $this->client_phone = $qs->client_phone;
        $this->dispatch('update_sale_product_id_field', $qs->product_id);
        $this->dispatch('update_seller_id_field', $qs->seller_id);
    }

    public function updateSale()
    {
        $this->validate();

        $qs = Sale::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;
        $qs->seller_id = $this->seller_id;
        $qs->client_name = $this->client_name;
        $qs->client_phone = $this->client_phone;

        $qs->save();
        $dispatched = WarehouseDispatch::where('product_id', $this->product_id)->where('assigned', $this->seller_id)
            ->where('date', $qs->date)->sum('quantity');

            if ($dispatched > 0) {
                if ($dispatched > $this->quantity) {
                    $dispatch_product = DispatchProduct::find($qs->dispatch_product_id);
                if($dispatch_product) {
                    $dispatch_product->quantity = $dispatched - $this->quantity;
                    $dispatch_product->save();
                }
            }
        }

        $this->resetForm();
        $this->dispatch('sale_distribution_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
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
        $this->reset();
    }

    public function render()
    {
        $products = Product::all();
        $users = User::whereHas('roles', function ($qs) {
            $qs->where('slug', 'product-distributor');
        })->get();
        return view('livewire.pages.sale.components.sales.sales-form', compact('users', 'products'));
    }
}
