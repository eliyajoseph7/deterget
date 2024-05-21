<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Exports\Sale\SoldProductExport;
use App\Helpers\Helper;
use App\Http\Controllers\PaginateController;
use App\Models\Sale;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';

    public $today;



    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('sale_distribution_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_distribution_sales')]
    public function deleteSale($id)
    {

        $qs = Sale::find($id);
        $qs->delete();

        $this->dispatch('distribution_deleted');
    }

    public function sortColumn($name)
    {
        if ($this->sortBy == $name) {
            $this->sortDir = ($this->sortDir == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $name;
        $this->sortDir = 'DESC';
    }

    public function getData() {
        
        if (Helper::has_role('cashier')) {
            $data = Sale::search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()->groupBy(['client.name', function ($qs) {
                return $qs->date;
            }]);
        } else if (Helper::has_role('credit-controller')) {
            $data = Sale::where('selling_type', 'credit')->search($this->search)->orderBy($this->sortBy, $this->sortDir)->get()->groupBy(['client.name', function ($qs) {
                return $qs->date;
            }]);
        } else {
            $data = Sale::search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->get()->groupBy(['client.name', function ($qs) {
                return $qs->date;
            }]);
        }


        return (new PaginateController)->paginate($data, $this->perPage);
        
    }

    public function exportExcel()
    {
        return (new SoldProductExport($this->search, $this->sortBy, $this->sortDir))->download('sold_products.xlsx');
    }


    public function mount(Request $request)
    {
        $this->today  = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $this->request = $request;
        
    }

    public function render()
    {
        $data = $this->getData();
        return view('livewire.pages.sale.components.sales.sales', compact('data'));
    }
}
