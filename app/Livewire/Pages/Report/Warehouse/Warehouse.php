<?php

namespace App\Livewire\Pages\Report\Warehouse;

use App\Models\WarehouseReport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Warehouse extends Component
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
        $data = WarehouseReport::search($this->search)->select('product_id', 'date', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        ->groupBy('date', 'product_id')
        ->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.report.warehouse.warehouse', compact('data'));
    }
}
