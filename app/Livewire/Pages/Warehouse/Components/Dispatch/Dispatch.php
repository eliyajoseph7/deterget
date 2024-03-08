<?php

namespace App\Livewire\Pages\Warehouse\Components\Dispatch;

use App\Models\WarehouseDispatch;
use App\Models\WarehouseTnx;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Dispatch extends Component
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

    #[On('warehouse_dispatch_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_warehouse_dispatch')]
    public function deleteWarehouseDispatch($id)
    {
        $qs = WarehouseDispatch::find($id);
        $tnx = WarehouseTnx::find($qs->warehouse_tnx_id);
        if($tnx) {
            $tnx->delete();
        }

        $qs->delete();

        $this->dispatch('warehouse_deleted');
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
    public function render()
    {
        $data = WarehouseDispatch::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.warehouse.components.dispatch.dispatch', compact('data'));
    }
}
