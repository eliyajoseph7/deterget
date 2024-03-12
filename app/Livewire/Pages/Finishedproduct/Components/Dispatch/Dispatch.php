<?php

namespace App\Livewire\Pages\Finishedproduct\Components\Dispatch;

use App\Models\DispatchProduct;
use App\Models\ProductReport;
use App\Models\ProductTnx;
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

    #[On('dispatch_product_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_product_dispatch')]
    public function deleteDispatchProduct($id)
    {
        $qs = DispatchProduct::find($id);
        $tnx = ProductTnx::find($qs->product_tnx_id);
        if($tnx) {
            $tnx->delete();
        }
        $report = ProductReport::where('product_tnx_id', $qs->product_tnx_id)->first();
        if($report) {
            $report->delete();
        }

        $qs->delete();

        $this->dispatch('product_deleted');
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
        $data = DispatchProduct::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.finishedproduct.components.dispatch.dispatch', compact('data'));
    }
}
