<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'invoice_code',
        'member_id',
        'date',
        'deadline',
        'payment_date',
        'extra_charge',
        'discount',
        'tax',
        'status',
        'user_id'
    ];

    const STATUS_NEW = 'new';
    const STATUS_PROCESS = 'process';
    const STATUS_FINISHED = 'finished';
    const STATUS_TAKEN = 'taken';

    // Ambil semua status enum
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PROCESS => 'Process',
            self::STATUS_FINISHED => 'Finished',
            self::STATUS_TAKEN => 'Taken',
        ];
    }
}
