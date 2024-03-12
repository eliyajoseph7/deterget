<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTnx extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword)
    {
        $qs->where('quantity', 'like', '%' . $keyword . '%')
        ->where('date', 'like', '%' . $keyword . '%')
            ->orWhereHas('item', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    }


    public function item()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }
}
