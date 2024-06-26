<?php

namespace App\Livewire\Pages\Setting\Client;

use App\Exports\Clients\ClientExport;
use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;


class ClientList extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 50;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';


    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('client_saved')]
    public function reload()
    {
        $this->render();
    }
    public function exportExcel()
    {
        return Excel::download(new ClientExport, 'clients.xlsx');
    }

    #[On('delete_client')]
    public function deleteClient($id)
    {

        Client::find($id)->delete();

        $this->dispatch('client_deleted');
    }

    public function sortColumn($name)
    {
        if ($this->sortBy == $name) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $name;
        $this->sortDir = 'DESC';
    }
    public function render()
    {
        $data = Client::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.setting.client.client-list', compact('data'));
    }
}
