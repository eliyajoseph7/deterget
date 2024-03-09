<?php

namespace App\Livewire\Pages\Sale;

use Livewire\Attributes\On;
use Livewire\Component;

class Distributions extends Component
{
    public $actvtab = 'sales';

    protected $listeners = [
        'set_distribution_actvtab' => 'switchTab'
    ];


    #[On('switch_distribution_tab')]
    public function switchTab($name) {
        $this->actvtab = $name;
    }

    public function render()
    {
        return view('livewire.pages.sale.distributions');
    }
}
