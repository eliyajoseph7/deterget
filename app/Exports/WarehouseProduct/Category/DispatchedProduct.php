<?php

namespace App\Exports\WarehouseProduct\Category;

use App\Models\WarehouseDispatch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DispatchedProduct implements FromView, WithTitle
{
    
    protected $search;
    protected $sortBy;
    protected $sortDir;
    
    public function __construct($search, $sortBy, $sortDir)
    {
        $this->search = $search;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
    }

    
    public function view(): View
    {
        return view('exports.warehouse.category.dispatched', [
            'data' => WarehouseDispatch::search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Dispatched Products';
    }
}
