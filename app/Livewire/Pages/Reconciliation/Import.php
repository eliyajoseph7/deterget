<?php

namespace App\Livewire\Pages\Reconciliation;

use App\Imports\TransactionImport;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Maatwebsite\Excel\Facades\Excel;

class Import extends ModalComponent
{
    use WithFileUploads;

    #[Validate('required|file|mimes:csv,xlsx,ods,xls')]
    public $file;


    public $importing = false;


    public function importFile() {

        $this->validate();

        // dd($this->file);
        $this->importing = true;
        Excel::import(new TransactionImport, $this->file);

        $this->importing = false;
        $this->closeModal();

        $this->dispatch('data_imported');
        $this->dispatch('show_success', 'Data imported successfully!');
    }

    public function render()
    {
        return view('livewire.pages.reconciliation.import');
    }
}
