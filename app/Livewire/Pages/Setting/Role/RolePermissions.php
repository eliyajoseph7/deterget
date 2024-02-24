<?php

namespace App\Livewire\Pages\Setting\Role;

use App\Models\Classification;
use App\Models\Role;
use Livewire\Component;

class RolePermissions extends Component
{
    public $slug;

    public function mount($slug) {
        $this->slug = $slug;
    }

    public function save($formData)
    {
        // dd($formData);
        $permissions = $formData;
        $role = Role::where('slug', $this->slug)->first();
        $role->permissions()->detach();

        foreach ($permissions as $key => $permission) {
            $role->permissions()->attach($permission);
        }

        $this->dispatch('attached', 'Permission(s) attached successfully');
    }

    public function render()
    {
        $classes = Classification::get();
        $role = Role::where('slug', $this->slug)->first();
        return view('livewire.pages.setting.role.role-permissions', compact('classes', 'role'));
    }
}
