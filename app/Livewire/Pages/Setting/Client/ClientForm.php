<?php

namespace App\Livewire\Pages\Setting\Client;

use App\Models\Client;
use Livewire\Attributes\Rule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ClientForm extends ModalComponent
{
    public $action = 'add';
    public $id;

    #[Rule('required')]
    public $name;
    #[Rule('required')]
    public $phone;


    protected $listeners = [
        'update_client' => 'editClient'
    ];


    public function addClient()
    {
        $this->validate();

        $client = new Client;
        $client->name = $this->name;
        $client->phone = $this->phone;
        $client->save();

        $this->resetForm();
        $this->dispatch('client_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Client saved successfully!');
    }

    public function editClient($id)
    {
        $this->action = 'update';
        $qs = Client::find($id);
        $this->id = $id;
        $this->name = $qs->name;
        $this->phone = $qs->phone;
    }

    public function updateClient()
    {
        $this->validate();

        $qs = Client::find($this->id);
        $qs->name = $this->name;
        $qs->phone = $this->phone;

        $qs->save();

        $this->resetForm();
        $this->dispatch('client_saved');
        $this->closeModal();
        $this->dispatch('show_success', 'Client updated successfully!');
    }

    public function mount($id = null) {
        if($id) {
            $this->editClient($id);
        }
    }


    public function resetForm() {
        $this->reset();
    }
    public function render()
    {
        return view('livewire.pages.setting.client.client-form');
    }
}
