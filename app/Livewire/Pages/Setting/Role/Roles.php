<?php

namespace App\Livewire\Pages\Setting\Role;

use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Roles extends Component
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

    #[On('role_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_role')]
    public function deleteRole($id)
    {

        Role::find($id)->delete();

        $this->dispatch('role_deleted');
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
        $data = Role::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.setting.role.roles', compact('data'));
    }
}
