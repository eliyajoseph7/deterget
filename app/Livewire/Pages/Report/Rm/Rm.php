<?php

namespace App\Livewire\Pages\Report\Rm;

use App\Models\MaterialReport;
use App\Models\MaterialTnx;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Rm extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortBy = 'date';
    public $sortDir = 'DESC';

    public $data = [];
    public $date;
    public $previousCount = 0;
    public $nextCount = 0;
    public $toNext = False;


    public function previous()
    {
        $this->previousCount += 1;
        $prev = date('Y-m-d', strtotime(now() . ' -' . $this->previousCount . ' month'));
        $this->date = new DateTime($prev);

        $this->fetchReport();
    }

    public function next()
    {
        $this->previousCount -= 1;
        $prev = date('Y-m-d', strtotime(now() . ' -' . $this->previousCount . ' month'));
        $this->date = new DateTime($prev);

        $this->fetchReport();
    }


    public function updatedSearch()
    {
        $this->fetchReport();
        $this->resetPage();
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

    public function fetchReport() {
        $data = MaterialReport::search($this->search)->select('raw_material_id', 'date', DB::raw('SUM(received) as received'), DB::raw('SUM(dispatched) as dispatched'))
        ->whereMonth('date', $this->date->format('m'))->whereYear('date', $this->date->format('Y'))
        ->groupBy('date', 'raw_material_id')
        ->orderBy($this->sortBy, $this->sortDir)->get();

        $this->data = $data;

        $diff = strtotime(now()) - strtotime(now() . ' -' . $this->previousCount . ' month');
        if ($diff == 0) {
            $this->toNext = False;
        } else {
            $this->toNext = True;
        }

    }

    public function mount()
    {
        $date = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
        $this->date = $date;
        $this->fetchReport();
    }

    public function render()
    {
        return view('livewire.pages.report.rm.rm');
    }
}
