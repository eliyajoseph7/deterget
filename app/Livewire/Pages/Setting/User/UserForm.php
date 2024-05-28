<?php

namespace App\Livewire\Pages\Setting\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use LivewireUI\Modal\ModalComponent;

class UserForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $email;

    #[Rule('required')]
    public $phone;

    // #[Rule('required')]
    public $password;

    #[Rule('required', as: 'Role')]
    public $roles = [];

    protected $listeners = [
        'update_user' => 'editUser'
    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }


    #[On('set_roles')]
    public function setRawMaterialId($roles)
    {
        $this->roles = $roles;
    }

    public function addUser()
    {
        $this->validate();

        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->password = Hash::make($this->password == null ? '1234' : $this->password);
        $user->save();

        foreach($this->roles as $role) {
            $user->roles()->attach($role);
            $permissions = Role::find($role)->permissions()->pluck('id');
            foreach($permissions as $permission) {
                $user->permissions()->attach($permission);
            }
        }

        $this->resetForm();
        $this->dispatch('user_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'User saved successfully!');
    }

    public function editUser($id)
    {
        $this->action = 'update';
        $qs = User::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->email = $qs->email;
        $this->phone = $qs->phone;
        $this->roles = $qs->roles()->pluck('id');
        
        $this->dispatch('update_roles_field', $this->roles);
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::find($this->id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        if($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $user->roles()->detach();
        $user->permissions()->detach();
        foreach($this->roles as $role) {
            try {
                $user->roles()->attach($role);
                $permissions = Role::find($role)->permissions()->pluck('id');
                foreach($permissions as $permission) {
                    $user->permissions()->attach($permission);
                }
            } catch (\Throwable $e) {}
        }

        $this->resetForm();
        $this->dispatch('user_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'User updated successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->editUser($id);
        }
        $this->dispatch('initialize_scripts');
    }


    public function resetForm()
    {
        $this->dispatch('reset_role');
        $this->reset();
    }
    public function render()
    {
        $user_roles = Role::where('slug', '!=', 'super-admin')->get();
        return view('livewire.pages.setting.user.user-form', compact('user_roles'));
    }
}
