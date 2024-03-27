<?php

namespace App\Livewire\Pages\Report\Sale;

use App\Exports\Reports\Sale\SaleReport;
use App\Models\Sale as ModelsSale;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Sale extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'date';
    public $sortDir = 'DESC';

    public $data = [];
    public $date;
    public $previousCount = 0;
    public $nextCount = 0;
    // public $total_days;
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

    public function sortColumn($name)
    {
        if ($this->sortBy == $name) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $name;
        $this->sortDir = 'DESC';
    }

    public function fetchReport()
    {

        $data = ModelsSale::search($this->search)->leftjoin('remains', 'remains.product_id', 'sales.product_id')
            ->join('users', 'users.id', 'sales.seller_id')
            ->select('users.name', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'), DB::raw('SUM(remains.quantity) as remained'))
            ->groupBy('sales.date', 'sales.product_id', 'users.name')
            ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
            ->orderBy($this->sortBy, $this->sortDir)->get()->groupBy('name')->all();

        $diff = strtotime(now()) - strtotime(now() . ' -' . $this->previousCount . ' month');
        if ($diff == 0) {
            $this->toNext = False;
        } else {
            $this->toNext = True;
        }

        $this->data = $data;
    }


    public function exportExcel()
    {
        $this->fetchReport();
        return (new SaleReport($this->search, $this->sortBy, $this->sortDir, $this->date))->download('detailed_sales_report.xlsx');
    }

    public function mount()
    {
        $this->date = now();
        // $this->total_days = cal_days_in_month(CAL_GREGORIAN, $this->date->format('m'), $this->date->format('Y'));
        $this->fetchReport();
    }

    public function render()
    {

        return view('livewire.pages.report.sale.sale');
    }
}
