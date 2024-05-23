<?php

namespace App\Livewire\Pages\Report\Sale;

use App\Exports\Reports\Sale\SaleReport;
use App\Models\Remain;
use App\Models\Sale as ModelsSale;
use App\Models\SaleItem;
use DateTime;
use DateTimeZone;
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

    public $filter = 'all';

    public function updatedFilter()
    {
        $this->fetchReport();
    }

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

        // $data = ModelsSale::search($this->search)
        //     ->leftjoin('remains', 'remains.product_id', 'sales.product_id')
        //     ->join('users', 'users.id', 'sales.seller_id')
        //     ->select('users.name', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'), DB::raw('SUM(remains.quantity) as remained'))
        //     ->groupBy('sales.date', 'sales.product_id', 'users.name')
        //     ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
        //     ->orderBy($this->sortBy, $this->sortDir)->get()->groupBy('name')->all();

        if ($this->filter == 'all') {
            // $data = ModelsSale::search($this->search)
            //     ->join('users', 'users.id', 'sales.seller_id')
            //     ->select('users.name', 'seller_id', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'))
            //     ->groupBy('sales.date', 'sales.product_id', 'users.name', 'seller_id')->with('product')
            //     ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
            //     ->orderBy($this->sortBy, $this->sortDir)->get();


            $data = SaleItem::search($this->search)
                ->join('sales', 'sales.id', 'sale_items.sale_id')
                ->join('users', 'users.id', 'sales.seller_id')
                ->select('users.name', 'sales.seller_id', 'sale_items.product_id', 'sales.date', DB::raw('SUM(sale_items.quantity) as sold'))
                ->groupBy('sales.date', 'sale_items.product_id', 'users.name', 'sales.seller_id')->with('product')
                ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
                ->orderBy($this->sortBy, $this->sortDir)->get();
        } else {
            // $data = ModelsSale::search($this->search)
            //     ->join('users', 'users.id', 'sales.seller_id')
            //     ->select('users.name', 'seller_id', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'))
            //     ->groupBy('sales.date', 'sales.product_id', 'users.name', 'seller_id')->with('product')
            //     ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
            //     ->where('selling_type', $this->filter)
            //     ->orderBy($this->sortBy, $this->sortDir)->get();

                $data = SaleItem::search($this->search)
                    ->join('sales', 'sales.id', 'sale_items.sale_id')
                    ->join('users', 'users.id', 'sales.seller_id')
                    ->select('users.name', 'sales.seller_id', 'sale_items.product_id', 'sales.date', DB::raw('SUM(sale_items.quantity) as sold'))
                    ->groupBy('sales.date', 'sale_items.product_id', 'users.name', 'sales.seller_id')->with('product')
                    ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
                    ->where('sales.selling_type', $this->filter)
                    ->orderBy($this->sortBy, $this->sortDir)->get();
        }

        $result = collect([]);

        foreach ($data as $dt) {
            $remain = Remain::where('product_id', $dt->product_id)->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), '=', $dt->date)->where('user_id', $dt->seller_id)->sum('quantity');
            $result->push([
                "name" => $dt->name,
                "product_id" => $dt->product_id,
                "product" => $dt->product,
                "date" => $dt->date,
                "sold" => $dt->sold,
                "remain" => $remain
            ]);
        }

        $this->data = $result->groupBy('name');

        $diff = strtotime(now()) - strtotime(now() . ' -' . $this->previousCount . ' month');
        if ($diff == 0) {
            $this->toNext = False;
        } else {
            $this->toNext = True;
        }
    }


    public function exportExcel()
    {
        $this->fetchReport();
        return (new SaleReport($this->search, $this->sortBy, $this->sortDir, $this->date, $this->filter))->download('detailed_sales_report.xlsx');
    }

    public function mount()
    {
        $date = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $this->date = $date;
        // $this->total_days = cal_days_in_month(CAL_GREGORIAN, $this->date->format('m'), $this->date->format('Y'));
        $this->fetchReport();
    }

    public function render()
    {

        return view('livewire.pages.report.sale.sale');
    }
}
