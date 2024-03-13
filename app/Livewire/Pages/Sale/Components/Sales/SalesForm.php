<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Models\DispatchProduct;
use App\Models\Product;
use App\Models\Sale;
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


    public function addSale()
    {
        $this->validate();

        $dispatch_product = new DispatchProduct;
        // $dispatch_product->date = $this->date;
        $dispatch_product->quantity = $this->quantity;
        $dispatch_product->product_id = $this->product_id;
        $dispatch_product->user_id = auth()->user()->id;

        $dispatch_product->save();

        $sale_distribution = new Sale;
        // $sale_distribution->date = $this->date;
        $sale_distribution->quantity = $this->quantity;
        $sale_distribution->product_id = $this->product_id;
        $sale_distribution->client_name = $this->client_name;
        $sale_distribution->client_phone = $this->client_phone;
        $sale_distribution->dispatch_product_id = $dispatch_product->id;
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
        $this->client_name = $qs->client_name;
        $this->client_phone = $qs->client_phone;
        $this->dispatch('update_sale_product_id_field', $qs->product_id);
    }

    public function updateSale()
    {
        $this->validate();

        $qs = Sale::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;
        $qs->client_name = $this->client_name;
        $qs->client_phone = $this->client_phone;

        $qs->save();

        $dispatch_product = DispatchProduct::find($qs->dispatch_product_id);
        $dispatch_product->quantity = $this->quantity;
        $dispatch_product->save();

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
        $this->reset();
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.pages.sale.components.sales.sales-form', compact('products'));
    }
}
