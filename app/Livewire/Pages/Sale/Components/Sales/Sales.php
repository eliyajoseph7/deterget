<?php

namespace App\Livewire\Pages\Sale\Components\Sales;

use App\Helpers\Helper;
use App\Models\Sale;
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

    // public $active;



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
    public function render()
    {
        if(Helper::has_role('cashier')) {
            $data = Sale::search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->paginate($this->perPage);
        } else {
            $data = Sale::where('selling_type', 'credit')->search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->paginate($this->perPage);
        }
        return view('livewire.pages.sale.components.sales.sales', compact('data'));
    }
}
