<?php

namespace App\Exports\WarehouseProduct\Category;

use App\Models\DispatchProduct;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReceivedProduct implements FromView, WithTitle
{
    
    private $search;
    private $sortBy;
    private $sortDir;
    
    public function __construct($search, $sortBy, $sortDir)
    {
        $this->search = $search;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
    }

    public function view(): View
    {
        return view('exports.warehouse.category.pending_received', [
            'data' => DispatchProduct::search($this->search)->where('warehouse_received', 'no')->orderBy($this->sortBy, $this->sortDir)->get()
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Products Pending Confirmation';
    }
}
