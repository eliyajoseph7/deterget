<?php

namespace App\Livewire\Pages\Report\Warehouse;

use App\Models\Product;
use App\Models\WarehouseReport;
use DateTime;
use DateTimeZone;
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

    public $data = [];
    public $productId;
    public $product;
    public $date;
    public $previousCount = 0;
    public $nextCount = 0;
    public $toNext = False;


    public function previous()
    {
        $this->previousCount += 1;
        $prev = date('Y-m-d', strtotime(now() . ' -' . $this->previousCount . ' month'));
        $this->date = new DateTime($prev);

        $this->fetchReport();
    }

    public function next()
    {
        $this->previousCount -= 1;
        $prev = date('Y-m-d', strtotime(now() . ' -' . $this->previousCount . ' month'));
        $this->date = new DateTime($prev);

        $this->fetchReport();
    }


    public function updatedSearch()
    {
        $this->fetchReport();
        $this->resetPage();
    }


    public function fetchReport() {
        $data = WarehouseReport::search($this->search)->select('date', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        ->whereMonth('date', $this->date->format('m'))->whereYear('date', $this->date->format('Y'))
        ->where('product_id', $this->productId)
        ->groupBy('date')
        ->orderBy($this->sortBy, $this->sortDir)->get();

        $this->data = $data;

        $diff = strtotime(now()) - strtotime(now() . ' -' . $this->previousCount . ' month');
        if ($diff == 0) {
            $this->toNext = False;
        } else {
            $this->toNext = True;
        }

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


    public function mount($productId) {
        $date = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $this->date = $date;
        $this->productId = $productId;
        $this->product = Product::find($productId);

        $this->fetchReport();
    }

    public function render()
    {
        // $data = WarehouseReport::search($this->search)->select('product_id', 'date', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        // ->groupBy('date', 'product_id')
        // ->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.report.warehouse.warehouse');
    }
}
