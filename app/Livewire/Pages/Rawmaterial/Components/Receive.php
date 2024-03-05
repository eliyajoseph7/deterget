<?php

namespace App\Livewire\Pages\Rawmaterial\Components;

use App\Models\ReceiveMaterial;
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

    #[On('material_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_material')]
    public function deleteReceiveMaterial($id)
    {

        ReceiveMaterial::find($id)->delete();

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
