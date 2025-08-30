<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'support_id',
        'user_id',
        'message',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
