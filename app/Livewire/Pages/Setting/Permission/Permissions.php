<?php

namespace App\Livewire\Pages\Setting\Permission;

use App\Models\Permission;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Permissions extends Component
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

    #[On('permission_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_permission')]
    public function deletePermission($id)
    {

        Permission::find($id)->delete();

        $this->dispatch('permission_deleted');
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
        $data = Permission::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        
        return view('livewire.pages.setting.permission.permissions', compact('data'));
    }
}
