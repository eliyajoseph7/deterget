<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseReport extends Model
{
    use HasFactory;
    
    public function scopeSearch($qs, $keyword)
    {
        $qs->where('date', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
