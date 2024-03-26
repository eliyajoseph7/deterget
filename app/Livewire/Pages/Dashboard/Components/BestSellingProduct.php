<?php

namespace App\Livewire\Pages\Dashboard\Components;

use App\Helpers\DashboardReports\BestSellingProductReport;
use Livewire\Component;

class BestSellingProduct extends Component
{
    public function render()
    {
        $data = BestSellingProductReport::getBestSellingProducts();
        return view('livewire.pages.dashboard.components.best-selling-product', compact('data'));
    }
}
