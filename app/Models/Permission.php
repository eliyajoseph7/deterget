<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    public function scopeSearch($qs, $keyword) {
        $qs->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('slug', 'like', '%'.$keyword.'%');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function classification() {
        return $this->belongsTo(Classification::class);
    }
}
