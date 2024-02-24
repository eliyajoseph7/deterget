<?php

namespace App\Livewire\Pages\Setting\Role;

use App\Models\Role;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class RoleForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required', as: 'Role')]
    public $name;

    public $slug;

    protected $listeners = [
        'update_role' => 'editRole'
    ];


    public function updatingRole() {
        // $this->generateSlug();
    }

    public function addRole()
    {
        $this->validate();

        $role = new Role;
        $role->name = $this->name;
        $role->slug = $this->slug;
        $role->save();

        $this->resetForm();
        $this->dispatch('role_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Role saved successfully!');
    }

    public function editRole($id)
    {
        $this->action = 'update';
        $qs = Role::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->slug = $qs->slug;
        // $this->dispatch('update_active_role_row', $id);
    }

    public function updateRole()
    {
        $this->validate();

        $qs = Role::find($this->id);
        $qs->name = $this->name;
        $qs->slug = $this->slug;

        $qs->save();

        $this->resetForm();
        $this->dispatch('role_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Role updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editRole($id);
        }
    }

    public function generateSlug() {
        $slug = strtolower(str_replace(' ', '-', $this->name));
        $this->slug = $slug;
    }

    public function resetForm() {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.pages.setting.role.role-form');
    }
}
