<?php

namespace App\Helpers\DashboardReports;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesTrend
{


    public static function getSalesTrend()
    {
        $categories = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->startOfDay();
            $sale = Sale::join('sale_items', 'sale_items.sale_id', 'sales.id')
                ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $date->format('Y-m-d'))->sum('price');

            array_push($categories, $i == 0 ? 'Today' : $date->format('D'));
            array_push($values, ($sale));
        }

        $data = [
            'categories' => $categories,
            'series' => [
                'name' => 'Amount',
                'data' => $values
            ],
        ];
        return $data;
    }
}
