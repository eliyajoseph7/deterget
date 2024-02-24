<?php

namespace App\Livewire\Pages\Setting\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    public $role_id;

    protected $listeners = [
        'update_user' => 'editUser'
    ];

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function addUser()
    {
        $this->validate();

        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->role_id = $this->role_id;
        $user->password = Hash::make($this->password == null ? '1234' : $this->password);
        $user->save();

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
        $this->role_id = $qs->role_id;
        
    }

    public function updateUser()
    {
        $this->validate();

        $user = User::find($this->id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->role_id = $this->role_id;

        $user->save();

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
    }


    public function resetForm()
    {
        $this->reset();
    }
    public function render()
    {
        $roles = Role::all();
        return view('livewire.pages.setting.user.user-form', compact('roles'));
    }
}
