<?php

namespace App\Livewire\Pages\Rawmaterial;

use Livewire\Attributes\On;
use Livewire\Component;

class RawMaterials extends Component
{
    public $actvtab = 'receive';

    protected $listeners = [
        'set_actvtab' => 'switchTab'
    ];


    #[On('switch_material_tab')]
    public function switchTab($name) {
        $this->actvtab = $name;
    }

    public function render()
    {
        return view('livewire.pages.rawmaterial.raw-materials');
    }
}
