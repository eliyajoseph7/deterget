<?php

namespace App\Livewire\Pages\Setting\Rawmaterial;

use App\Models\RawMaterial;
use App\Models\Uom;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class RawMaterialForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;

    #[Rule('required', as: 'Unit of measure')]
    public $uom_id;

    protected $listeners = [
        'update_material' => 'editRawMaterial'
    ];


    public function addRawMaterial()
    {
        $this->validate();

        $material = new RawMaterial;
        $material->name = $this->name;
        $material->uom_id = $this->uom_id;
        $material->user_id = auth()->user()->id;
        $material->save();

        $this->resetForm();
        $this->dispatch('material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Raw material saved successfully!');
    }

    public function editRawMaterial($id)
    {
        $this->action = 'update';
        $qs = RawMaterial::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->uom_id = $qs->uom_id;
        // $this->dispatch('update_active_material_row', $id);
    }

    public function updateRawMaterial()
    {
        $this->validate();

        $qs = RawMaterial::find($this->id);
        $qs->name = $this->name;
        $qs->uom_id = $this->uom_id;

        $qs->save();

        $this->resetForm();
        $this->dispatch('material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Raw material updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editRawMaterial($id);
        }
    }

    public function resetForm() {
        $this->dispatch('reset_uom');
        $this->reset();
    }

    public function render()
    {
        $measures = Uom::all();
        return view('livewire.pages.setting.rawmaterial.raw-material-form', compact('measures'));
    }
}
