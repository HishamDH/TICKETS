<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantChat extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'user_id',
        'subject',
        'description',
        'attachment',
        'additional_data',
        
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
    
    public function messages()
    {
        return $this->hasMany(MerchantMessage::class, 'merchant_chat_id');
    }
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
