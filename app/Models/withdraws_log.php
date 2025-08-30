<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class withdraws_log extends Model
{
    use HasFactory;
    protected $table = 'withdraw_logs';
    protected $fillable = [
        'user_id',
        'withdraw_id',
        'amount',
        'status',
        'additional_data',
    ];
    protected $casts = [
        'additional_data' => 'array',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
