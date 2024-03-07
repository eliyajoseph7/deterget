<?php

namespace App\Livewire\Pages\Rawmaterial\Components;

use App\Models\MaterialTnx;
use App\Models\RawMaterial;
use App\Models\ReceiveMaterial;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class ReceiveForm extends ModalComponent
{
    use WithFileUploads;

    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $quantity;
    #[Rule('required')]
    public $date;

    public $invoice;


    public $new_invoice;

    #[Rule('required', as: 'Material')]
    public $raw_material_id;

    protected $listeners = [
        'update_receive_material' => 'editReceiveMaterial'
    ];

    #[On('set_raw_material_id')]
    public function setRawMaterialId($id)
    {
        $this->raw_material_id = $id;
    }


    public function addReceiveMaterial()
    {
        $this->validate();

        $this->validate([
            'invoice' => 'required|mimes:pdf'
        ]);

        // save in material tnx table
        $tnx = new MaterialTnx;
        $tnx->date = $this->date;
        $tnx->quantity = $this->quantity;
        $tnx->raw_material_id = $this->raw_material_id;
        $tnx->user_id = auth()->user()->id;
        $tnx->save();

        $receive_material = new ReceiveMaterial;
        $receive_material->date = $this->date;
        $receive_material->quantity = $this->quantity;
        $receive_material->raw_material_id = $this->raw_material_id;
        $receive_material->material_tnx_id = $tnx->id;
        $receive_material->user_id = auth()->user()->id;

        $fileNameToSave = null;
        if ($this->invoice != null) {
            $this->file = (object)$this->invoice;
            try {
                $file = $this->file->getClientOriginalName();
                $extension = $this->file->getClientOriginalExtension();
                $fileName = pathinfo($file, PATHINFO_FILENAME) . "-" . date('Ymd-His') . "." . $extension;
                $this->file->storeAs('rawmaterial/invoices', $fileName, 'public');

                $fileNameToSave = '/storage/rawmaterial/invoices/' . $fileName;
            } catch (\Throwable $e) {
            }
        }
        $receive_material->invoice = $fileNameToSave;

        $receive_material->save();

        $this->resetForm();
        $this->dispatch('receive_material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Record saved successfully!');
    }

    public function editReceiveMaterial($id)
    {
        $this->action = 'update';
        $qs = ReceiveMaterial::find($id);
        $this->id = $id;
        $this->quantity = $qs->quantity;
        $this->date = $qs->date;
        $this->invoice = $qs->invoice;
        $this->raw_material_id = $qs->raw_material_id;
        $this->dispatch('update_raw_material_id_field', $qs->raw_material_id);
    }

    public function updateReceiveMaterial()
    {
        $this->validate();

        if ($this->new_invoice) {
            $this->validate([
                'new_invoice' => 'required|mimes:pdf'
            ]);
        }

        $qs = ReceiveMaterial::find($this->id);
        $qs->quantity = $this->quantity;
        $qs->date = $this->date;
        $qs->raw_material_id = $this->raw_material_id;

        $tnx = MaterialTnx::find($qs->material_tnx_id);
        if ($tnx) {
            $tnx->date = $this->date;
            $tnx->quantity = $this->quantity;
            $tnx->raw_material_id = $this->raw_material_id;
            $tnx->save();
        } else { // if it is not there, create it
            $tnx = new MaterialTnx;
            $tnx->date = $this->date;
            $tnx->quantity = $this->quantity;
            $tnx->raw_material_id = $this->raw_material_id;
            $tnx->user_id = auth()->user()->id;
            $tnx->save();
        }

        // check if new invoice is added and replace the previous invoice
        if ($this->new_invoice) {
            $fileNameToSave = null;
            $this->file = (object)$this->new_invoice;
            try {
                $file = $this->file->getClientOriginalName();
                $extension = $this->file->getClientOriginalExtension();
                $fileName = pathinfo($file, PATHINFO_FILENAME) . "-" . date('Ymd-His') . "." . $extension;

                $invoice = $qs->invoice;
                if ($invoice) {
                    $imgname = str_replace(substr($invoice, 0, 9), '', $invoice);
                    $check = Storage::disk('public')->exists($imgname);
                    if ($check) {
                        Storage::disk('public')->delete($imgname);
                    }
                }

                $this->file->storeAs('rawmaterial/invoices', $fileName, 'public');

                $fileNameToSave = '/storage/rawmaterial/invoices/' . $fileName;
            } catch (\Throwable $e) {
            }
            $qs->invoice = $fileNameToSave;
        }

        $qs->material_tnx_id = $tnx->id;
        $qs->save();

        $this->resetForm();
        $this->dispatch('receive_material_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'ReceiveMaterial updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editReceiveMaterial($id);
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
        return view('livewire.pages.rawmaterial.components.receive-form', compact('materials'));
    }
}
