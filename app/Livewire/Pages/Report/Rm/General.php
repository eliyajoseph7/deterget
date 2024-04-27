<?php

namespace App\Livewire\Pages\Report\Rm;

use App\Models\MaterialReport;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class General extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'date';
    public $sortDir = 'DESC';

    public $data = [];

    public function updatedSearch()
    {
        $this->fetchReport();
        $this->resetPage();
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

    public function fetchReport() {
        $data = MaterialReport::search($this->search)->select('raw_material_id', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        ->groupBy('raw_material_id')
        ->orderBy($this->sortBy, $this->sortDir)->get();

        $this->data = $data;


    }

    public function mount()
    {
        $this->fetchReport();
    }

    public function render()
    {
        return view('livewire.pages.report.rm.general');
    }
}
