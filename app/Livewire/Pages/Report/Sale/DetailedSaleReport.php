<?php

namespace App\Livewire\Pages\Report\Sale;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DetailedSaleReport extends Component
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
        $data = Sale::searchReport($this->search)->
        leftjoin('remains', 'remains.product_id', 'sales.product_id')
        ->join('users', 'users.id', 'sales.seller_id')
        ->select('users.name', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'), DB::raw('SUM(remains.quantity) as remained'))
        ->groupBy('sales.date', 'sales.product_id', 'users.name')
        ->orderBy($this->sortBy, $this->sortDir)->get()->groupBy('name');

        // dd($data);
        return view('livewire.pages.report.sale.detailed-sale-report', compact('data'));
    }
}
