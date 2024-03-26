<?php

namespace App\Helpers\DashboardReports;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class BestSellingProductReport {
    
    public static function getBestSellingProducts() {

        $chart = Sale::join('products', 'products.id', 'sales.product_id')->select('products.name as name', DB::raw('COUNT(sales.id) as y') )
                    ->groupBy('products.name')->orderByDesc('y')->limit(6)->get();

        $series[] = [
            'name' => 'Best Selling Products',
            'colorByPoint' => true,
            'data' => $chart
        ];
        return $series;
    }

}