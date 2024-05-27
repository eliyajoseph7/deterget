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
    #[Rule('required')]
    public $tinNumber;

    public $vrNumber;
    public $bankAccount;
    public $bankName;

    #[Rule('required')]
    public $address;


    protected $listeners = [
        'update_client' => 'editClient'
    ];


    public function addClient()
    {
        $this->validate();

        $client = new Client;
        $client->name = $this->name;
        $client->phone = $this->phone;
        $client->tinNumber = $this->tinNumber;
        $client->vrNumber = $this->vrNumber;
        $client->bankAccount = $this->bankAccount;
        $client->bankName = $this->bankName;
        $client->address = $this->address;
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
        $this->vrNumber = $qs->vrNumber;
        $this->bankAccount = $qs->bankAccount;
        $this->bankName = $qs->bankName;
        $this->address = $qs->address;
    }

    public function updateClient()
    {
        $this->validate();

        $qs = Client::find($this->id);
        $qs->name = $this->name;
        $qs->phone = $this->phone;
        $qs->tinNumber = $this->tinNumber;
        $qs->vrNumber = $this->vrNumber;
        $qs->bankAccount = $this->bankAccount;
        $qs->bankName = $this->bankName;
        $qs->address = $this->address;

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
