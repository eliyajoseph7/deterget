<?php

namespace App\Livewire\Pages\Warehouse\Components\Product;

use App\Models\DispatchProduct;
use App\Models\WarehouseReport;
use App\Models\WarehouseTnx;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class ConfirmForm extends ModalComponent
{
    public $id;

    #[Rule('required', as: 'Confirmation')]
    public $warehouse_received;
    

    #[Rule('required')]
    public $comment;



    public function confirmProductReceival()
    {
        $this->validate();


        $qs = DispatchProduct::find($this->id);
        $qs->warehouse_received = $this->warehouse_received;
        $qs->comment = $this->comment;

        $qs->save();

        if($this->warehouse_received == 'yes') {
            $tnx = new WarehouseTnx;
            $tnx->quantity = $qs->quantity;
            $tnx->pieces = $qs->pieces;
            $tnx->action = 'in';
            $tnx->product_id = $qs->product_id;
            $tnx->user_id = auth()->user()->id;
            $tnx->save();
    
            // create report
            $report = new WarehouseReport;
            $report->received = $qs->quantity;
            $report->product_id = $qs->product_id;
            $report->pieces = $qs->pieces;
            $report->warehouse_tnx_id = $tnx->id;
            $report->user_id = auth()->user()->id;
            $report->save();
        }

        $this->resetForm();
        $this->dispatch('confirm_received');
        $this->closeModal();
        $this->dispatch('show_success', 'Record updated successfully!');
    }

    public function mount($id)
    {
        $this->id = $id;

    }

    public function resetForm()
    {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.pages.warehouse.components.product.confirm-form');
    }
}
