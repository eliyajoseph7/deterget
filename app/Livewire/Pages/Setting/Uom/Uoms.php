<?php

namespace App\Livewire\Pages\Setting\Uom;

use App\Models\Uom;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Uoms extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';


    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('uom_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_uom')]
    public function deleteUom($id)
    {

        Uom::find($id)->delete();

        $this->dispatch('uom_deleted');
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
        $data = Uom::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.setting.uom.uoms', compact('data'));
    }
}
