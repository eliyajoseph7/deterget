<?php

namespace App\Livewire\Pages\Warehouse\Components\Product;

use App\Exports\WarehouseProduct\WarehouseProductExport;
use App\Models\DispatchProduct;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';

    // public $active;



    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('confirm_received')]
    public function reload()
    {
        $this->render();
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

    public function exportExcel()
    {
        return (new WarehouseProductExport($this->search, $this->sortBy, $this->sortDir, 'received'))->download('warehouse_pending_products.xlsx');
    }

    public function render()
    {
        $data = DispatchProduct::search($this->search)
                ->where('warehouse_received', 'no')->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.warehouse.components.product.product-list', compact('data'));
    }
}
