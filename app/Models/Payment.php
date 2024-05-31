<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoiceno',
        'amount',
        'paymode',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date'
    ];
    
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'invoiceno', 'invoiceno');
    }

}
