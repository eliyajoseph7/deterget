<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    public static $paymodes = ['Cash', 'Bank', 'Lipa Namba'];

    public function scopeSearch($qs, $keyword)
    {
        $qs->where('client_name', 'like', '%' . $keyword . '%')
            ->orWhere('sales.quantity', 'like', '%' . $keyword . '%')
            ->orWhere('client_phone', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('seller', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    }

    protected $casts = [
        'date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items() {
        return $this->hasMany(SaleItem::class);
    }

    public function transactions() {
        return $this->hasOne(Transaction::class, 'invoiceno', 'invoiceno');
    }

    public function reconciliation() {
        return $this->hasOne(Reconciliation::class, 'invoiceno', 'invoiceno');
    }

    public function scopeSearchReport($qs, $keyword)
    {
        $qs->orWhere('sales.quantity', 'like', '%' . $keyword . '%')
            // ->where('client_name', 'like', '%' . $keyword . '%')
            // ->orWhere('client_phone', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('client', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
    }

    // protected $appends = ['amount'];
    
    // public function getAmountAttribute() {
    //     return SaleItem::where('sale_id', $this->id)->sum('price');
    // }

    protected $appends = ['due_date', 'balance', 'overdue'];

    public function getDueDateAttribute() {
        return $this->date->addDays($this->credit_days);
        
    }

    public function getBalanceAttribute() {
        $balance = $this->items->sum('price') - $this->transactions?->amount ?? 0;
        return $balance;
    }

    public function getOverdueAttribute() {
        return now() > $this->getDueDateAttribute();
    }
}
