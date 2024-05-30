<?php

namespace App\Livewire\Pages\Dashboard\Components;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TroubleClients extends Component
{
    public $data = [];

    public function getData()
    {
        $qs = Sale::doesntHave('reconciliation')
            ->join('clients', 'sales.client_id', 'clients.id')
            ->select('clients.name', DB::raw('COUNT(sales.invoiceno) as total'))
            ->groupBy('clients.name')->limit(10)->get()->sortByDesc('total');

        $this->data = $qs;

        // dd($qs);
    }

    public function mount()
    {
        $this->getData();
    }
    public function render()
    {
        return view('livewire.pages.dashboard.components.trouble-clients');
    }
}
