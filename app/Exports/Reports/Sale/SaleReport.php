<?php

namespace App\Exports\Reports\Sale;

use App\Models\Remain;
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

        $data = Sale::search($this->search)
            ->join('users', 'users.id', 'sales.seller_id')
            ->select('users.name', 'seller_id', 'sales.product_id', 'sales.date', DB::raw('SUM(sales.quantity) as sold'))
            ->groupBy('sales.date', 'sales.product_id', 'users.name', 'seller_id')->with('product')
            ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
            ->orderBy($this->sortBy, $this->sortDir)->get();

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

        return view('exports.reports.sale.sale-report', [
            'data' => $result->groupBy('name'),
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
