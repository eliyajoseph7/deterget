<?php

namespace App\Livewire\Pages\Setting\Permission;

use App\Models\Classification;
use App\Models\Permission;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class PermissionForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required', as: 'Permission')]
    public $name;
    #[Rule('required', as: 'Permission class')]
    public $classification_id;

    public $slug;

    protected $listeners = [
        'update_permission' => 'editPermission'
    ];


    public function updatingPermission() {
        // $this->generateSlug();
    }

    public function addPermission()
    {
        $this->validate();

        $permission = new Permission;
        $permission->name = $this->name;
        $permission->slug = $this->slug;
        $permission->classification_id = $this->classification_id;
        $permission->user_id = auth()->user()->id;
        $permission->save();

        $this->resetForm();
        $this->dispatch('permission_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Permission saved successfully!');
    }

    public function editPermission($id)
    {
        $this->action = 'update';
        $qs = Permission::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->slug = $qs->slug;
        $this->classification_id = $qs->classification_id;
        // $this->dispatch('update_active_permission_row', $id);
    }

    public function updatePermission()
    {
        $this->validate();

        $qs = Permission::find($this->id);
        $qs->name = $this->name;
        $qs->slug = $this->slug;
        $qs->classification_id = $this->classification_id;

        $qs->save();

        $this->resetForm();
        $this->dispatch('permission_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Permission updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editPermission($id);
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
        $classifications = Classification::all();
        return view('livewire.pages.setting.permission.permission-form', compact('classifications'));
    }
}
