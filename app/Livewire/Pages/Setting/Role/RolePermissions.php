<?php

namespace App\Livewire\Pages\Setting\Role;

use App\Helpers\Helper;
use App\Models\Classification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

        $users = $role->users;
        foreach($users as $user) {
            $user->permissions()->detach();
            $roles = $user->roles;
            foreach($roles as $role) {
                $permissions = $role->permissions()->pluck('id');
                foreach($permissions as $permission) {
                    $user->permissions()->attach($permission);
                }
            }
        }

        $this->dispatch('attached', 'Permission(s) attached successfully');
    }

    public function render()
    {
        if(Helper::is_super_admin()) {
            $classes = Classification::all();
        } else {
            $classes = Classification::where('name', '!=', 'Permissions')->get();
        }
        $role = Role::where('slug', $this->slug)->first();
        return view('livewire.pages.setting.role.role-permissions', compact('classes', 'role'));
    }
}
