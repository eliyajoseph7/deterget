<?php

namespace App\Exports\Material\Category;

use App\Models\DispatchMaterial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DispatchedMaterial implements FromView, WithTitle
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
        return view('exports.material.category.dispatched', [
            'data' => DispatchMaterial::search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Dispatched Materials';
    }
}
