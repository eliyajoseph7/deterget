<?php

namespace App\Exports\FinishedGood\Category;

use App\Models\DispatchProduct;
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
        return view('exports.product.category.dispatched', [
            'data' => DispatchProduct::search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()
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
