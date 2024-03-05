<?php

namespace App\Livewire\Pages\Setting\Rawmaterial;

use App\Models\RawMaterial;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingRawMaterials extends Component
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
    public function deleteRawMaterial($id)
    {

        RawMaterial::find($id)->delete();

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
        $data = RawMaterial::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.setting.rawmaterial.setting-raw-materials', compact('data'));
    }
}
