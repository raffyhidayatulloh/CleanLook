<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'package_id',
        'quantity',
        'description'
    ];

    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
