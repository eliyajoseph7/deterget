<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword)
    {
        $qs->where('name', 'like', '%' . $keyword . '%')
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('uom', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    protected $appends = ['product_name'];

    public function getProductNameAttribute() {
        return $this->category->name . ' ' . $this->name . ' ' . $this->quantity . ' ' . $this->uom->name;
    }
}
