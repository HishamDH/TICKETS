<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchantwithdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'amount',
        'status',
        'transaction_id',
        'additional_data',
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
}
