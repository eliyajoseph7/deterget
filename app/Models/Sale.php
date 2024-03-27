<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeSearchReport($qs, $keyword)
    {
        $qs->where('client_name', 'like', '%' . $keyword . '%')
            ->orWhere('sales.quantity', 'like', '%' . $keyword . '%')
            ->orWhere('client_phone', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    }
}
