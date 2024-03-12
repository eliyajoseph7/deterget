<?php

namespace App\Livewire\Pages\Report\Rm;

use App\Models\MaterialReport;
use App\Models\MaterialTnx;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Rm extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'date';
    public $sortDir = 'DESC';

    // public $active;


    public function updatedSearch()
    {
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
    public function render()
    {
        $data = MaterialReport::search($this->search)->select('raw_material_id', 'date', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        ->groupBy('date', 'raw_material_id')
        ->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.report.rm.rm', compact('data'));
    }
}
