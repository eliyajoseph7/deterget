<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoiceno',
        'amount',
        'paymode',
    ];

    protected $casts = [
        'date' => 'date'
    ];
    
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'invoiceno', 'invoiceno');
    }

    public function reconciliation()
    {
        return $this->belongsTo(Reconciliation::class, 'invoiceno', 'invoiceno');
    }

    protected $appends = ['balance'];

    public function getBalanceAttribute() {
        $balance = $this->sale->items->sum('price') - $this->amount;
        return $balance;
    }
}
