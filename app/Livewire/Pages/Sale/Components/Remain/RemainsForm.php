<?php

namespace App\Livewire\Pages\Sale\Components\Remain;

use App\Models\Product;
use App\Models\Remain;
use App\Models\WarehouseTnx;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class RemainsForm extends ModalComponent
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
        'update_remain_distribution' => 'editRemain'
    ];

    #[On('set_remain_product_id')]
    public function setRemainProductId($id)
    {
        $this->product_id = $id;
    }


    public function addRemain()
    {
        $this->validate();

        $tnx = new WarehouseTnx;
        // $tnx->date = $this->date;
        $tnx->quantity = $this->quantity;
        $tnx->product_id = $this->product_id;
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $remain_distribution = new Remain;
        // $remain_distribution->date = $this->date;
        $remain_distribution->quantity = $this->quantity;
        $remain_distribution->product_id = $this->product_id;
        $remain_distribution->warehouse_tnx_id = $tnx->id;
        $remain_distribution->user_id = auth()->user()->id;

        $remain_distribution->save();

        $this->resetForm();
        $this->dispatch('remain_distribution_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editRemain($id)
    {
        $this->action = 'update';
        $qs = Remain::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        // $this->date = $qs->date;
        $this->product_id = $qs->product_id;
        $this->dispatch('update_remain_product_id_field', $qs->product_id);
    }

    public function updateRemain()
    {
        $this->validate();

        $qs = Remain::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;


        $tnx = WarehouseTnx::find($qs->warehouse_tnx_id);
        if ($tnx) {
            // $tnx->date = $this->date;
            $tnx->quantity = $this->quantity;
            $tnx->product_id = $this->product_id;
            $tnx->save();
        }

        $qs->warehouse_tnx_id = $tnx->id;
        $qs->save();

        $this->resetForm();
        $this->dispatch('remain_distribution_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editRemain($id);
        }

        $this->dispatch('initialize_scripts');
    }

    public function resetForm()
    {
        $this->dispatch('reset_remain_product_id');
        $this->reset();
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.pages.sale.components.remain.remains-form', compact('products'));
    }
}
