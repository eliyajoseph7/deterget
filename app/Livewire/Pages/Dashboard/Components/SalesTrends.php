<?php

namespace App\Livewire\Pages\Dashboard\Components;

use App\Helpers\DashboardReports\SalesTrend;
use Carbon\Carbon;
use Livewire\Component;

class SalesTrends extends Component
{
    public function render()
    {
        $data = SalesTrend::getSalesTrend();
        return view('livewire.pages.dashboard.components.sales-trends', compact('data'));
    }
}
