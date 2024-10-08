<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'type',
        'package_name',
        'price'
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
}
