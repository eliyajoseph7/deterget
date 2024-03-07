<?php

namespace App\Livewire\Pages\Rawmaterial\Components;

use App\Models\DispatchMaterial;
use App\Models\MaterialTnx;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Dispatch extends Component
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

    #[On('dispatch_material_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_material_dispatch')]
    public function deleteDispatchMaterial($id)
    {
        $qs = DispatchMaterial::find($id);
        $tnx = MaterialTnx::find($qs->material_tnx_id);
        if($tnx) {
            $tnx->delete();
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
        $data = DispatchMaterial::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.rawmaterial.components.dispatch', compact('data'));
    }
}
