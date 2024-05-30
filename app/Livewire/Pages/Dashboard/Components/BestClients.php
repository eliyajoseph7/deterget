<?php

namespace App\Livewire\Pages\Dashboard\Components;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BestClients extends Component
{
    public $data = [];

    public function getData()
    {
        // $qs = Sale::join('reconciliations', 'sales.invoiceno', 'reconciliations.invoiceno')
        //     ->join('clients', 'sales.client_id', 'clients.id')
        //     ->select('clients.name', DB::raw('COUNT(sales.invoiceno) as total'))
        //     ->groupBy('clients.name')->limit(10)->get()->sortByDesc('total');

        $qs = Sale::leftJoin('reconciliations', 'sales.invoiceno', '=', 'reconciliations.invoiceno')
            ->join('clients', 'sales.client_id', '=', 'clients.id')
            ->select(
                'clients.name',
                DB::raw('COUNT(sales.invoiceno) as total'),
                DB::raw('SUM(CASE WHEN reconciliations.invoiceno IS NOT NULL THEN 1 ELSE 0 END) as paid'),
                DB::raw('SUM(CASE WHEN reconciliations.invoiceno IS NULL THEN 1 ELSE 0 END) as not_paid'),
                DB::raw('SUM(CASE WHEN reconciliations.invoiceno IS NOT NULL THEN 1 ELSE 0 END) - SUM(CASE WHEN reconciliations.invoiceno IS NULL THEN 1 ELSE 0 END) as difference')
            )
            ->groupBy('clients.name')
            ->orderByDesc('difference')
            ->limit(10)
            ->get();

        $this->data = $qs;

        // dd($qs);
    }

    public function mount()
    {
        $this->getData();
    }

    public function render()
    {
        return view('livewire.pages.dashboard.components.best-clients');
    }
}
