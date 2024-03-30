<?php

namespace App\Exports\Sale;

use App\Helpers\Helper;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SoldProductExport implements FromView, WithTitle
{
    use Exportable;

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

        if(Helper::has_role('cashier')) {
            $data = Sale::search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->get();
        } else {
            $data = Sale::where('selling_type', 'credit')->search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->get();
        }
        return view('exports.sale.sold', [
            'data' => $data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sold Products';
    }
}
