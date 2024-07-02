<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function scopeSearch($qs, $keyword) {
        $qs->where('name', 'like', '%'.$keyword.'%')
        ->orWhere('phone', 'like', '%'.$keyword.'%')
        ->orWhere('tin_number', 'like', '%'.$keyword.'%')
        ->orWhere('bank_account', 'like', '%'.$keyword.'%')
        ->orWhere('bank_name', 'like', '%'.$keyword.'%')
        ->orWhere('vr_number', 'like', '%'.$keyword.'%');
    }
}
