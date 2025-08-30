<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_chat_id',
        'user_id',
        'message',
        'type',
        'additional_data',
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
    public function chat()
    {
        return $this->belongsTo(MerchantChat::class, 'merchant_chat_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
