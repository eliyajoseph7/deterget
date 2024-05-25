<?php

namespace App\Imports;

use App\Models\Transaction;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransactionImport implements ToModel, WithUpserts, WithHeadingRow
{

    public function uniqueBy()
    {
        return 'invoiceno';
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $date = Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
        $qs = Transaction::where('invoiceno', $row['invoiceno'])->first();
        if (!$qs) {
            $qs = Transaction::create([
                'date' => $date,
                'invoiceno' => $row['invoiceno'],
                'amount' => $row['amount'],
            ]);
        } else {
            $qs->date = $date;
            $qs->invoiceno = $row['invoiceno'];
            $qs->amount = $row['amount'];

            $qs->save();
        }

        return;
    }
}
