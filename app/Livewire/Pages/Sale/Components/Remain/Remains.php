<?php

namespace App\Livewire\Pages\Sale\Components\Remain;

use App\Models\Remain;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Remains extends Component
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

    #[On('remain_distribution_saved')]
    public function reload()
    {
        $this->render();
    }

    #[On('delete_distribution_remains')]
    public function deleteRemain($id)
    {
        $qs = Remain::find($id);
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
        $data = Remain::search($this->search)->orderBy($this->sortBy, $this->sortDir)->where('user_id', auth()->user()->id)->paginate($this->perPage);
        return view('livewire.pages.sale.components.remain.remains', compact('data'));
    }
}
