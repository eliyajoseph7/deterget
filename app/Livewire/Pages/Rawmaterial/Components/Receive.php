<?php

namespace App\Livewire\Pages\Rawmaterial\Components;

use App\Models\MaterialTnx;
use App\Models\ReceiveMaterial;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Receive extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';

    // public $active;



    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('receive_material_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_material_receive')]
    public function deleteReceiveMaterial($id)
    {

        $qs = ReceiveMaterial::find($id);
        $tnx = MaterialTnx::find($qs->material_tnx_id);
        if($tnx) {
            $tnx->delete();
        }

        $invoice = $qs->invoice;
        if ($invoice) {
            $imgname = str_replace(substr($invoice, 0, 9), '', $invoice);
            $check = Storage::disk('public')->exists($imgname);
            if ($check) {
                Storage::disk('public')->delete($imgname);
            }
        }
        $qs->delete();

        $this->dispatch('material_deleted');
    }

    public function sortColumn($name)
    {
        if ($this->sortBy == $name) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $name;
        $this->sortDir = 'DESC';
    }
    public function render()
    {
        $data = ReceiveMaterial::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.rawmaterial.components.receive', compact('data'));
    }
}
