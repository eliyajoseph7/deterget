<?php

namespace App\Livewire\Pages\Rawmaterial\Components\Dispatch;

use App\Models\DispatchMaterial;
use App\Models\MaterialReport;
use App\Models\MaterialTnx;
use App\Models\RawMaterial;
use Livewire\Component;

class MaterialDispatchMultiple extends Component
{
    public $action = 'add';
    public $id;
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
            'purpose' => null,
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


        foreach ($this->fields as $field) {
            // save in material tnx table
            $tnx = new MaterialTnx;
            $tnx->date = $field['date'];
            $tnx->quantity = -$field['quantity'];
            $tnx->action = 'out';
            $tnx->raw_material_id = $field['raw_material_id'];
            $tnx->user_id = auth()->user()->id;
            $tnx->save();

            $dispatch_material = new DispatchMaterial;
            $dispatch_material->date = $field['date'];
            $dispatch_material->quantity = $field['quantity'];
            $dispatch_material->raw_material_id = $field['raw_material_id'];
            $dispatch_material->purpose = $field['purpose'];
            $dispatch_material->material_tnx_id = $tnx->id;
            $dispatch_material->user_id = auth()->user()->id;

            $dispatch_material->save();


            // create report
            $report = new MaterialReport;
            $report->date = $field['date'];
            $report->dispatched = $field['quantity'];
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
            'purpose' => null,
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
        return view('livewire.pages.rawmaterial.components.dispatch.material-dispatch-multiple', compact('materials'));
    }
}
