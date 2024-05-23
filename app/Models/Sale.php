<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

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
}
