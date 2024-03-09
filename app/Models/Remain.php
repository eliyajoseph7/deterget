<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remain extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword) {
        $qs->Where('quantity', 'like', '%'.$keyword.'%')
            ->orWhereHas('product', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
    });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
