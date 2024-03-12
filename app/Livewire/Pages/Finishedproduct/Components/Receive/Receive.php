<?php

namespace App\Livewire\Pages\Finishedproduct\Components\Receive;

use App\Models\ProductReport;
use App\Models\ProductTnx;
use App\Models\ReceiveProduct;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Receive extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('receive_product_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_product_receive')]
    public function deleteReceiveProduct($id)
    {

        $qs = ReceiveProduct::find($id);
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
        $data = ReceiveProduct::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);
        return view('livewire.pages.finishedproduct.components.receive.receive', compact('data'));
    }
}
