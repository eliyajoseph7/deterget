<?php

namespace App\Livewire\Pages\Setting\Uom;

use App\Models\Uom;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class UomForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;


    protected $listeners = [
        'update_uom' => 'editUom'
    ];


    public function addUom()
    {
        $this->validate();

        $uom = new Uom;
        $uom->name = $this->name;
        $uom->user_id = auth()->user()->id;
        $uom->save();

        $this->resetForm();
        $this->dispatch('uom_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Uom saved successfully!');
    }

    public function editUom($id)
    {
        $this->action = 'update';
        $qs = Uom::find($id);
        $this->id = $id;
        $this->name = $qs->name;
    }

    public function updateUom()
    {
        $this->validate();

        $qs = Uom::find($this->id);
        $qs->name = $this->name;

        $qs->save();

        $this->resetForm();
        $this->dispatch('uom_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Uom updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editUom($id);
        }
    }


    public function resetForm() {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.pages.setting.uom.uom-form');
    }
}
