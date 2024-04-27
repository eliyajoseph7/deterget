<?php

namespace App\Livewire\Pages\Finishedproduct\Components\Dispatch;

use App\Models\DispatchProduct;
use App\Models\Product;
use App\Models\ProductReport;
use App\Models\ProductTnx;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DispatchForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $quantity;
    #[Rule('required')]
    public $date;

    #[Rule('required', as: 'Product')]
    public $product_id;

    protected $listeners = [
        'update_dispatch_product' => 'editDispatchProduct'
    ];

    #[On('set_dispatch_product_id')]
    public function setProductId($id)
    {
        $this->product_id = $id;
    }


    public function addDispatchProduct()
    {
        $this->validate();


        // save in product tnx table
        $tnx = new ProductTnx;
        $tnx->date = $this->date;
        $tnx->quantity = -$this->quantity;
        $tnx->action = 'out';
        $tnx->product_id = $this->product_id;
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $dispatch_product = new DispatchProduct;
        $dispatch_product->date = $this->date;
        $dispatch_product->quantity = $this->quantity;
        $dispatch_product->product_id = $this->product_id;
        $dispatch_product->product_tnx_id = $tnx->id;
        $dispatch_product->user_id = auth()->user()->id;

        $dispatch_product->save();

        // create report
        $report = new ProductReport;
        $report->date = $this->date;
        $report->dispatched = $this->quantity;
        $report->product_id = $this->product_id;
        $report->product_tnx_id = $tnx->id;
        $report->user_id = auth()->user()->id;
        $report->save();

        $this->resetForm();
        $this->dispatch('dispatch_product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editDispatchProduct($id)
    {
        $this->action = 'update';
        $qs = DispatchProduct::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        $this->date = $qs->date;
        $this->product_id = $qs->product_id;
        $this->dispatch('update_product_id_field', $qs->product_id);
    }

    public function updateDispatchProduct()
    {
        $this->validate();


        $qs = DispatchProduct::find($this->id);
        $qs->quantity = $this->quantity;
        $qs->date = $this->date;
        $qs->product_id = $this->product_id;

        $tnx = ProductTnx::find($qs->product_tnx_id);
        if ($tnx) {
            $tnx->date = $this->date;
            $tnx->quantity = -$this->quantity;
            $tnx->product_id = $this->product_id;
            $tnx->action = 'out';
            $tnx->save();
        }

        $qs->product_tnx_id = $tnx->id;
        $qs->save();

        // update report
        $report = ProductReport::where('product_tnx_id', $tnx->id)->first();
        if($report) {
            $report->date = $this->date;
            $report->dispatched = $this->quantity;
            $report->product_id = $this->product_id;
            $report->product_tnx_id = $tnx->id;
            $report->save();
        }

        $this->resetForm();
        $this->dispatch('dispatch_product_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editDispatchProduct($id);
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
        return view('livewire.pages.finishedproduct.components.dispatch.dispatch-form', compact('products'));
    }
}
