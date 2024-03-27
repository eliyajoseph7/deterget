<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\DispatchProduct;
use App\Models\Remain;
use App\Models\Sale;
use App\Models\WarehouseDispatch;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemainSaleController extends Controller
{
    public function remain()
    {
        $this->returnToWarehouse();
    }

    public function returnToWarehouse()
    {
        $date = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $dispatched = WarehouseDispatch::select('product_id', DB::raw('SUM(quantity) as quantity'))->groupBy('product_id')
            ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $date->format('Y-m-d'))
            ->get();

        foreach ($dispatched as $dispatch) {
            $sale = Sale::where('product_id', $dispatch->product_id)->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $date->format('Y-m-d'))->sum('quantity');
            $remain = $dispatch->quantity - $sale;
            if ($remain > 0) {
                $dispatch_product = new DispatchProduct;
                $dispatch_product->date = $date;
                $dispatch_product->quantity = $remain;
                $dispatch_product->product_id = $dispatch->product_id;

                $dispatch_product->save();
            }
        }

        $this->populateRemainTable();
    }

    public function populateRemainTable()
    {
        $date = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $dispatched = WarehouseDispatch::select('product_id', 'assigned', DB::raw('SUM(quantity) as quantity'))->groupBy('product_id', 'assigned')
            ->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $date->format('Y-m-d'))
            ->get();


        foreach ($dispatched as $dispatch) {
            $sale = Sale::where('seller_id', $dispatch->assigned)->where('product_id', $dispatch->product_id)->where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $date->format('Y-m-d'))->sum('quantity');
            $remain = $dispatch->quantity - $sale;
            if ($remain > 0) {

                $remain_distribution = new Remain;
                $remain_distribution->date = $date;
                $remain_distribution->quantity = $remain;
                $remain_distribution->product_id = $dispatch->product_id;
                $remain_distribution->user_id = $dispatch->assigned;

                $remain_distribution->save();
            }
        }
    }
}
