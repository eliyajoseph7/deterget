<?php

namespace App\Imports;

use App\Models\Payment;
use App\Models\Reconciliation;
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

        $done = Reconciliation::where('invoiceno', $row['invoiceno'])->first();
        if(!$done) {
            $date = Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
            $qs = Transaction::where('invoiceno', $row['invoiceno'])->first();
            $transDate = $qs?->date;
            if (!$qs) {
                $qs = Transaction::create([
                    'date' => $date,
                    'invoiceno' => $row['invoiceno'],
                    'amount' => $row['amount'],
                    'paymode' => $row['paymode'],
                ]);
            } else {
                $qs->date = $date;
                $qs->invoiceno = $row['invoiceno'];
                $qs->paymode = $row['paymode'];
                if($date != $transDate->format('Y-m-d')) {
                    $qs->amount += $row['amount'];
                } else {
                    $qs->amount = $row['amount'];
                }
    
                $qs->save();
            }

            // insert into payments table for history purposes
            Payment::create([
                'date' => $date,
                'invoiceno' => $row['invoiceno'],
                'amount' => $row['amount'],
                'paymode' => $row['paymode'],
                'user_id' => auth()->user()->id,
            ]);
        }

        return;
    }
}
