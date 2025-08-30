<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supports extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'category',
        'status',
        'attachment',
        'staff_id',
        'additional_data'
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}

