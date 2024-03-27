<?php

namespace App\Exports\Material;

use App\Exports\Material\Category\DispatchedMaterial;
use App\Exports\Material\Category\ReceivedMaterial;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MaterialExport implements WithMultipleSheets
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
            $sheets[] = new ReceivedMaterial($this->search, $this->sortBy, $this->sortDir);
        } else {
            $sheets[] = new DispatchedMaterial($this->search, $this->sortBy, $this->sortDir);
        }

        return $sheets;
    }
}
