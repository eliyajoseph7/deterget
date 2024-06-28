<?php

namespace App\Exports\Clients;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClientExport implements FromView, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  view(): View
    {
        $data = Client::all();
        return view('exports.clients.clients', [
            'data' => $data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Clients';
    }

}
