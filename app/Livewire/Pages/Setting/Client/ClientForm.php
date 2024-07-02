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
    public $tin_number;

    public $vr_number;
    public $bank_account;
    public $bank_name;

    #[Rule('required')]
    public $address;
    #[Rule('required')]
    public $contact_person;
    #[Rule('required')]
    public $contact_phone;


    protected $listeners = [
        'update_client' => 'editClient'
    ];


    public function addClient()
    {
        $this->validate();

        $client = new Client;
        $client->name = $this->name;
        $client->phone = $this->phone;
        $client->tin_number = $this->tin_number;
        $client->vr_number = $this->vr_number;
        $client->bank_account = $this->bank_account;
        $client->bank_name = $this->bank_name;
        $client->address = $this->address;
        $client->contact_person = $this->contact_person;
        $client->contact_phone = $this->contact_phone;
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
        $this->vr_number = $qs->vr_number;
        $this->bank_account = $qs->bank_account;
        $this->bank_name = $qs->bank_name;
        $this->address = $qs->address;
        $this->contact_person = $qs->contact_person;
        $this->contact_phone = $qs->contact_phone;
    }

    public function updateClient()
    {
        $this->validate();

        $qs = Client::find($this->id);
        $qs->name = $this->name;
        $qs->phone = $this->phone;
        $qs->tin_number = $this->tin_number;
        $qs->vr_number = $this->vr_number;
        $qs->bank_account = $this->bank_account;
        $qs->bank_name = $this->bank_name;
        $qs->address = $this->address;
        $qs->contact_person = $this->contact_person;
        $qs->contact_phone = $this->contact_phone;

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
