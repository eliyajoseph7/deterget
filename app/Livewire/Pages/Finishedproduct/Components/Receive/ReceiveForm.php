<?php

namespace App\Livewire\Pages\Finishedproduct\Components\Receive;

use App\Models\Product;
use App\Models\ProductReport;
use App\Models\ProductTnx;
use App\Models\ReceiveProduct;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class ReceiveForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $quantity;
    // #[Rule('required')]
    // public $date;

    #[Rule('required', as: 'Product')]
    public $product_id;

    protected $listeners = [
        'update_receive_product' => 'editReceiveProduct'
    ];

    #[On('set_product_id')]
    public function setRawProductId($id)
    {
        $this->product_id = $id;
    }


    public function addReceiveProduct()
    {
        $this->validate();

        // save in product tnx table
        $tnx = new ProductTnx;
        // $tnx->date = $this->date;
        $tnx->quantity = $this->quantity;
        $tnx->product_id = $this->product_id;
        $tnx->action = 'in';
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $receive_product = new ReceiveProduct;
        // $receive_product->date = $this->date;
        $receive_product->quantity = $this->quantity;
        $receive_product->product_id = $this->product_id;
        $receive_product->product_tnx_id = $tnx->id;
        $receive_product->user_id = auth()->user()->id;

        $receive_product->save();

        // create report
        $report = new ProductReport;
        $report->received = $this->quantity;
        $report->product_id = $this->product_id;
        $report->product_tnx_id = $tnx->id;
        $report->user_id = auth()->user()->id;
        $report->save();

        $this->resetForm();
        $this->dispatch('receive_product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editReceiveProduct($id)
    {
        $this->action = 'update';
        $qs = ReceiveProduct::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        // $this->date = $qs->date;
        $this->product_id = $qs->product_id;
        $this->dispatch('update_product_id_field', $qs->product_id);
    }

    public function updateReceiveProduct()
    {
        $this->validate();


        $qs = ReceiveProduct::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;

        $tnx = ProductTnx::find($qs->product_tnx_id);
        if ($tnx) {
            // $tnx->date = $this->date;
            $tnx->quantity = $this->quantity;
            $tnx->product_id = $this->product_id;
            $tnx->action = 'in';
            $tnx->save();
        } else { // if it is not there, create it
            $tnx = new ProductTnx;
            // $tnx->date = $this->date;
            $tnx->quantity = $this->quantity;
            $tnx->action = 'in';
            $tnx->product_id = $this->product_id;
            $tnx->user_id = auth()->user()->id;
            $tnx->save();
        }


        $qs->product_tnx_id = $tnx->id;
        $qs->save();

        // update report
        $report = ProductReport::where('product_tnx_id', $tnx->id)->first();
        if($report) {
            $report->received = $this->quantity;
            $report->product_id = $this->product_id;
            $report->product_tnx_id = $tnx->id;
            $report->save();
        }

        $this->resetForm();
        $this->dispatch('receive_product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editReceiveProduct($id);
        }

        $this->dispatch('initialize_scripts');
    }

    public function resetForm()
    {
        $this->dispatch('reset_product_id');
        $this->reset();
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.pages.finishedproduct.components.receive.receive-form', compact('products'));
    }
}
