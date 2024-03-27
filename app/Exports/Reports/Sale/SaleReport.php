<?php

namespace App\Exports\Reports\Sale;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SaleReport implements FromView, WithTitle
{
    use Exportable;

    protected $search;
    protected $sortBy;
    protected $sortDir;
    protected $date;

    public function __construct($search, $sortBy, $sortDir, $date)
    {
        $this->search = $search;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->date = $date;
    }


    public function view(): View
    {
        return view('exports.reports.sale.sale-report', [
            'data' => Sale::search($this->search)->leftjoin('remains', 'remains.product_id', 'sales.product_id')
                ->join('users', 'users.id', 'sales.seller_id')
                ->select('users.name', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'), DB::raw('SUM(remains.quantity) as remained'))
                ->groupBy('sales.date', 'sales.product_id', 'users.name')
                ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
                ->orderBy($this->sortBy, $this->sortDir)->get()->groupBy('name'),
            'date' => $this->date
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Detailed Sales Transactions';
    }
}
