<?php

namespace App\Livewire\Pages\Warehouse;

use Livewire\Attributes\On;
use Livewire\Component;

class Warehouses extends Component
{
    public $actvtab = 'confirm';

    protected $listeners = [
        'set_actv_warehouse_tab' => 'switchTab'
    ];


    #[On('switch_warehouse_tab')]
    public function switchTab($name) {
        $this->actvtab = $name;
    }

    public function render()
    {
        return view('livewire.pages.warehouse.warehouses');
    }
}
