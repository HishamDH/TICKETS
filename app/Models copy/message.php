<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'ticket_id',
        'user_id',
        'additional_data'
    ];
    protected $casts = [
        'additional_data' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // إذا كان الحقل user_id
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id'); // إذا كنت تخزن staff_id في نفس جدول users
    }

}

