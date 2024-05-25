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
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function sale() {
        return $this->belongsTo(Sale::class, 'invoiceno');
    }
}
