<?php

namespace App\Livewire\Pages\Rawmaterial\Components\Receive;

use App\Models\MaterialReport;
use App\Models\MaterialTnx;
use App\Models\RawMaterial;
use App\Models\ReceiveMaterial;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MaterialReceiveMultiple extends Component
{
    use WithFileUploads;

    public $action = 'add';
    public $id;
    public $invoice;
    public $fields = [];


    public function addField()
    {
        $this->validate([
            'fields.*.*' => ['required'],
        ], [
            'fields.*.*.required' => 'This field is required.',
        ]);

        $this->fields[] = [
            'quantity' => null,
            'date' => null,
            // 'invoice' => null,
            'raw_material_id' => null,
        ];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields); // Reset array keys

    }


    public function addReceiveMaterial()
    {
        $this->validate([
            'fields.*.*' => ['required'],
        ], [
            'fields.*.*.required' => 'This field is required.',
        ]);

        $this->validate([
            'invoice' => 'required|mimes:pdf'
        ]);

        foreach($this->fields as $field) {
            $field['invoice'] = $this->invoice;
            // save in material tnx table
            $tnx = new MaterialTnx;
            $tnx->date = $field['date'];
            $tnx->quantity = $field['quantity'];
            $tnx->action = 'in';
            $tnx->raw_material_id = $field['raw_material_id'];
            $tnx->user_id = auth()->user()->id;
            $tnx->save();
    
            $receive_material = new ReceiveMaterial;
            $receive_material->date = $field['date'];
            $receive_material->quantity = $field['quantity'];
            $receive_material->raw_material_id = $field['raw_material_id'];
            $receive_material->material_tnx_id = $tnx->id;
            $receive_material->user_id = auth()->user()->id;
    
            $fileNameToSave = null;
            if ($field['invoice'] != null) {
                $this->file = (object)$field['invoice'];
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
    
            // create report
            $report = new MaterialReport;
            $report->received = $field['quantity'];
            $report->raw_material_id = $field['raw_material_id'];
            $report->material_tnx_id = $tnx->id;
            $report->user_id = auth()->user()->id;
            $report->save();
        }

        $this->resetForm();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Records saved successfully!',
        ]);

        return redirect()->route('raw_materials');
    }


    public function mount()
    {
        $this->fields[] = [
            'quantity' => null,
            'date' => null,
            // 'invoice' => null,
            'raw_material_id' => null,
        ];

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
        return view('livewire.pages.rawmaterial.components.receive.material-receive-multiple', compact('materials'));
    }
}
