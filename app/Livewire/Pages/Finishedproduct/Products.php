<?php

namespace App\Livewire\Pages\Finishedproduct;

use Livewire\Attributes\On;
use Livewire\Component;

class Products extends Component
{
    public $actvtab = 'receive';

    protected $listeners = [
        'set_actv_product_tab' => 'switchTab'
    ];


    #[On('switch_product_tab')]
    public function switchTab($name) {
        $this->actvtab = $name;
    }

    public function render()
    {
        return view('livewire.pages.finishedproduct.products');
    }
}
