<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchMaterial extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword)
    {
        $qs->where('quantity', 'like', '%' . $keyword . '%')
        ->where('date', 'like', '%' . $keyword . '%')
            ->orWhereHas('item', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhereHas('uom', function ($qs) use ($keyword) {
                        $qs->orWhere('name', 'like', '%' . $keyword . '%');
                    });
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }
}
