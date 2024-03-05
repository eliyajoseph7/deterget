<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword) {
        $qs->where('name', 'like', '%'.$keyword.'%')
        ->orWhereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
