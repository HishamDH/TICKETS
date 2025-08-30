<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'balance',
        'locked_balance',
        'additional_data',
        'withdrawn_total',
    ];
    protected $casts = [
        'balance' => 'decimal:2',
        'locked_balance' => 'decimal:2',
        'withdrawn_total' => 'decimal:2',
        'additional_data' => 'array',
    ];
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
    public function transactions()
    {
        return $this->hasMany(PaysHistory::class, 'wallet_id');
    }
}
