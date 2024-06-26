<?php

namespace App\Livewire\Pages\Report\Rm;

use App\Models\DispatchMaterial;
use App\Models\RawMaterial;
use App\Models\ReceiveMaterial;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RmMovement extends Component
{
    public $materialId;
    public $date;
    public $material;
    public $series;

    public $totalReceived;
    public $totalDispatched;


    public function getMovementChart()
    {

        $received = ReceiveMaterial::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $this->date)->where('raw_material_id', $this->materialId)->sum('quantity');

        $dispatched = DispatchMaterial::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $this->date)->where('raw_material_id', $this->materialId)->sum('quantity');
        $chart[] = [
            'name' => 'Received' . ' ('. $received . ' ' . $this->material->uom->name . ')',
            'y' => $received,
            'sliced' => true,
            'selected' => true,
        ];
        $chart[] = [
            'name' => 'Dispatched' . ' ('. $dispatched . ' ' . $this->material->uom->name . ')',
            'y' => $dispatched
        ];
        $chart[] = [
            'name' => 'Balance' . ' ('. $received - $dispatched . ' ' . $this->material->uom->name . ')',
            'y' => $received - $dispatched
        ];

        $series[] = [
            'name' => $this->material?->name,
            'colorByPoint' => true,
            'data' => $chart
        ];
        $this->series = $series;
    }

    public function mount($material, $date)
    {
        $this->materialId = $material;
        $this->date = $date;
        $this->material = RawMaterial::find($material);
    }

    public function render()
    {
        $received = ReceiveMaterial::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $this->date)
            ->where('raw_material_id', $this->materialId)->orderBy('created_at', 'ASC')->get();

        $dispatched = DispatchMaterial::where(DB::raw("(DATE_FORMAT(date,'%Y-%m-%d'))"), $this->date)
            ->where('raw_material_id', $this->materialId)->orderBy('created_at', 'ASC')->get();

        $this->totalReceived = $received->sum('quantity');
        $this->totalDispatched = $dispatched->sum('quantity');
        
        $this->getMovementChart();
        return view('livewire.pages.report.rm.rm-movement', compact('received', 'dispatched'));
    }
}
