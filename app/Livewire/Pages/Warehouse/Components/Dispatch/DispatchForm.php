<?php

namespace App\Livewire\Pages\Warehouse\Components\Dispatch;

use App\Models\Product;
use App\Models\User;
use App\Models\WarehouseDispatch;
use App\Models\WarehouseReport;
use App\Models\WarehouseTnx;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class DispatchForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $quantity;
    // #[Rule('required')]
    // public $date;

    #[Rule('required', as: 'Assigned seller')]
    public $assigned;

    #[Rule('required', as: 'Product')]
    public $product_id;
    #[Rule('required', as: 'number of pieces')]
    public $pieces;

    protected $listeners = [
        'update_warehouse_dispatch' => 'editWarehouseDispatch'
    ];

    #[On('set_dispatch_product_id')]
    public function setProductId($id)
    {
        $this->product_id = $id;
        $this->pieces = Product::find($id)->total_pieces ?? 1;
    }

    #[On('set_assigned')]
    public function setAssigned($id)
    {
        $this->assigned = $id;
    }


    public function addWarehouseDispatch()
    {
        $this->validate();


        // save in warehouse tnx table
        $tnx = new WarehouseTnx;
        // $tnx->date = $this->date;
        $tnx->quantity = -$this->quantity;
        $tnx->pieces = -$this->pieces;
        $tnx->action = 'out';
        $tnx->product_id = $this->product_id;
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $warehouse_dispatch = new WarehouseDispatch;
        // $warehouse_dispatch->date = $this->date;
        $warehouse_dispatch->quantity = $this->quantity;
        $warehouse_dispatch->pieces = $this->pieces;
        $warehouse_dispatch->product_id = $this->product_id;
        $warehouse_dispatch->warehouse_tnx_id = $tnx->id;
        $warehouse_dispatch->assigned = $this->assigned;
        $warehouse_dispatch->user_id = auth()->user()->id;

        $warehouse_dispatch->save();

        // create report
        $report = new WarehouseReport;
        $report->dispatched = $this->quantity;
        $report->product_id = $this->product_id;
        $report->pieces = $this->pieces;
        $report->warehouse_tnx_id = $tnx->id;
        $report->user_id = auth()->user()->id;
        $report->save();

        $this->resetForm();
        $this->dispatch('warehouse_dispatch_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editWarehouseDispatch($id)
    {
        $this->action = 'update';
        $qs = WarehouseDispatch::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        $this->pieces = $qs->pieces;
        // $this->date = $qs->date;
        $this->product_id = $qs->product_id;
        $this->assigned = $qs->assigned;
        $this->dispatch('update_product_id_field', $qs->product_id);
        $this->dispatch('update_assigned_field', $qs->assigned);
    }

    public function updateWarehouseDispatch()
    {
        $this->validate();


        $qs = WarehouseDispatch::find($this->id);
        $qs->quantity = $this->quantity;
        $qs->pieces = $this->pieces;
        // $qs->date = $this->date;
        $qs->product_id = $this->product_id;

        $tnx = WarehouseTnx::find($qs->warehouse_tnx_id);
        if ($tnx) {
            // $tnx->date = $this->date;
            $tnx->quantity = -$this->quantity;
            $tnx->pieces = -$this->pieces;
            $tnx->action = 'out';
            $tnx->product_id = $this->product_id;
            $tnx->save();
        }

        $qs->warehouse_tnx_id = $tnx->id;
        $qs->save();

        // update report
        $report = WarehouseReport::where('warehouse_tnx_id', $tnx->id)->first();
        if($report) {
            $report->dispatched = $this->quantity;
            $report->product_id = $this->product_id;
            $report->pieces = $this->pieces;
            $report->warehouse_tnx_id = $tnx->id;
            $report->save();
        }

        $this->resetForm();
        $this->dispatch('warehouse_dispatch_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editWarehouseDispatch($id);
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
        // $users = User::where('id', '!=', auth()->user()->id)->get();
        $users = User::whereHas('roles', function ($qs) {
            $qs->where('slug', 'product-distributor');
        })->get();
        return view('livewire.pages.warehouse.components.dispatch.dispatch-form', compact('products', 'users'));
    }
}
