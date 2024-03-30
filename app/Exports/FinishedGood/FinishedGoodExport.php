<?php

namespace App\Exports\FinishedGood;

use App\Exports\FinishedGood\Category\DispatchedProduct;
use App\Exports\FinishedGood\Category\ReceivedProduct;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinishedGoodExport implements WithMultipleSheets
{
    use Exportable;

    protected $search;
    protected $sortBy;
    protected $sortDir;
    protected $category;
    
    public function __construct($search, $sortBy, $sortDir, $category)
    {
        $this->search = $search;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->category = $category;
    }
    
    public function sheets(): array
    {
        $sheets = [];

        if($this->category == 'received') {
            $sheets[] = new ReceivedProduct($this->search, $this->sortBy, $this->sortDir);
        } else {
            $sheets[] = new DispatchedProduct($this->search, $this->sortBy, $this->sortDir);
        }

        return $sheets;
    }
}
