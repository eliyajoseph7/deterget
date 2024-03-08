<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchProduct extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword)
    {
        $qs->where('quantity', 'like', '%' . $keyword . '%')
        ->where('date', 'like', '%' . $keyword . '%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                    // ->orWhereHas('category', function ($qs) use ($keyword) {
                    //     $qs->orWhere('name', 'like', '%' . $keyword . '%');
                    // });
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
