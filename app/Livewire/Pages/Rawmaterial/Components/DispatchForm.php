<?php

namespace App\Livewire\Pages\Rawmaterial\Components;

use App\Models\DispatchMaterial;
use App\Models\MaterialReport;
use App\Models\MaterialTnx;
use App\Models\RawMaterial;
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
    
    #[Rule('required')]
    public $purpose;


    #[Rule('required', as: 'Material')]
    public $raw_material_id;

    protected $listeners = [
        'update_dispatch_material' => 'editDispatchMaterial'
    ];

    #[On('set_dispatch_raw_material_id')]
    public function setRawMaterialId($id)
    {
        $this->raw_material_id = $id;
    }


    public function addDispatchMaterial()
    {
        $this->validate();


        // save in material tnx table
        $tnx = new MaterialTnx;
        // $tnx->date = $this->date;
        $tnx->quantity = -$this->quantity;
        $tnx->action = 'out';
        $tnx->raw_material_id = $this->raw_material_id;
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $dispatch_material = new DispatchMaterial;
        // $dispatch_material->date = $this->date;
        $dispatch_material->quantity = $this->quantity;
        $dispatch_material->raw_material_id = $this->raw_material_id;
        $dispatch_material->purpose = $this->purpose;
        $dispatch_material->material_tnx_id = $tnx->id;
        $dispatch_material->user_id = auth()->user()->id;

        $dispatch_material->save();

        // create report
        $report = new MaterialReport;
        $report->dispatched = $this->quantity;
        $report->raw_material_id = $this->raw_material_id;
        $report->material_tnx_id = $tnx->id;
        $report->user_id = auth()->user()->id;
        $report->save();


        $this->resetForm();
        $this->dispatch('dispatch_material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editDispatchMaterial($id)
    {
        $this->action = 'update';
        $qs = DispatchMaterial::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        // $this->date = $qs->date;
        $this->purpose = $qs->purpose;
        $this->raw_material_id = $qs->raw_material_id;
        $this->dispatch('update_raw_material_id_field', $qs->raw_material_id);
    }

    public function updateDispatchMaterial()
    {
        $this->validate();


        $qs = DispatchMaterial::find($this->id);
        $qs->quantity = $this->quantity;
        // $qs->date = $this->date;
        $qs->purpose = $this->purpose;
        $qs->raw_material_id = $this->raw_material_id;

        $tnx = MaterialTnx::find($qs->material_tnx_id);
        if ($tnx) {
            // $tnx->date = $this->date;
            $tnx->quantity = -$this->quantity;
            $tnx->action = 'out';
            $tnx->raw_material_id = $this->raw_material_id;
            $tnx->save();
        }

        $qs->material_tnx_id = $tnx->id;
        $qs->save();

        // update report
        $report = MaterialReport::where('material_tnx_id', $tnx->id)->first();
        if($report) {
            $report->dispatched = $this->quantity;
            $report->raw_material_id = $this->raw_material_id;
            $report->material_tnx_id = $tnx->id;
            $report->save();
        }

        $this->resetForm();
        $this->dispatch('dispatch_material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'DispatchMaterial updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editDispatchMaterial($id);
        }

        $this->dispatch('initialize_scripts');
    }

    public function resetForm()
    {
        $this->dispatch('reset_raw_material_id');
        $this->reset();
    }

    public function render()
    {
        $materials = RawMaterial::all();
        return view('livewire.pages.rawmaterial.components.dispatch-form', compact('materials'));
    }
}
