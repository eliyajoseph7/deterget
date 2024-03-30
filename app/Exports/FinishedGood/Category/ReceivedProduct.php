<?php

namespace App\Exports\FinishedGood\Category;

use App\Models\ReceiveProduct;
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
        return view('exports.product.category.received', [
            'data' => ReceiveProduct::search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Received Products';
    }
}
