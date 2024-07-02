<?php

namespace App\Exports\Reports\Sale;

use App\Models\Remain;
use App\Models\Sale;
use App\Models\SaleItem;
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
    protected $filter;

    public function __construct($search, $sortBy, $sortDir, $date, $filter)
    {
        $this->search = $search;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->date = $date;
        $this->filter = $filter;
    }


    public function view(): View
    {

        if ($this->filter == 'all') {
            $data = SaleItem::search($this->search)
                ->join('sales', 'sales.id', 'sale_items.sale_id')
                ->join('users', 'users.id', 'sales.seller_id')
                ->select('users.name', 'sales.seller_id', 'sale_items.product_id', 'sales.date', DB::raw('SUM(sale_items.quantity) as sold'))
                ->groupBy('sales.date', 'sale_items.product_id', 'users.name', 'sales.seller_id')->with('product')
                ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
                ->orderBy($this->sortBy, $this->sortDir)->get();
        } else {
            $data = SaleItem::search($this->search)
                ->join('sales', 'sales.id', 'sale_items.sale_id')
                ->join('users', 'users.id', 'sales.seller_id')
                ->select('users.name', 'sales.seller_id', 'sale_items.product_id', 'sales.date', DB::raw('SUM(sale_items.quantity) as sold'))
                ->groupBy('sales.date', 'sale_items.product_id', 'users.name', 'sales.seller_id')->with('product')
                ->whereMonth('sales.date', $this->date->format('m'))->whereYear('sales.date', $this->date->format('Y'))
                ->where('sales.selling_type', $this->filter)
                ->orderBy($this->sortBy, $this->sortDir)->get();
        }

        $data->transform(function($qs) {
            $price = ($qs->product->selling_price * $qs->sold);
            $vat = 0.18 * $price;
            $qs->price = $price + $vat;
            return $qs;
        });

        $result = collect([]);

        foreach ($data as $dt) {
            $remain = Remain::where('product_id', $dt->product_id)->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), '=', $dt->date)->where('user_id', $dt->seller_id)->sum('quantity');
            $result->push([
                "name" => $dt->name,
                "product_id" => $dt->product_id,
                "product" => $dt->product,
                "date" => $dt->date,
                "sold" => $dt->sold,
                "price" => $dt->price,
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
